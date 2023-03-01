<?php

namespace App\Http\Controllers;

use App\Models\CalendarTime;
use App\Models\ChiefAppointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChiefAppointmentsController extends Controller
{
    public function save(Request $request)
    {
        if (!auth()->check()) return abort(404);
        $data = json_decode($request->getContent(), true);

        if (!array_key_exists('id', $data)) $data['id'] = '-1';

        try {

            $date = CalendarTime::whereRaw("id" . "=" . $data['time_id'] . " AND cast(concat(calendar_times.date, ' ', calendar_times.time) as datetime) > CURRENT_TIMESTAMP()")->first();
            if (!$date)
                return json_encode(["error" => true, "status"=>-1, "message" => "Дату не знайдено!"]);


            $findedByData = $this->getActualUserNotesToBoss();
            if ($findedByData)
                return json_encode(["error" => true, "status"=>-2, "date"=>$findedByData->date . " " . $findedByData->time]);

            $findedByData = ChiefAppointment::where([["id", "!=", auth()->user()->id], "time_id" => $data['time_id']])->first();
            if ($findedByData)
                return json_encode(["error" => true, "status"=>-3,"message" => "Запис на вибраний час зробити не можна!"]);


            $findedByData = ChiefAppointment::where(["time_id" => $data['time_id']])->first();
            if ($findedByData && $findedByData['id'] == $data['id'] && $findedByData["time_id"] == $data['time_id'] && $findedByData["status"] == $data['status'])
                return json_encode(["error" => false, "message" => ""]);

            $date = ChiefAppointment::firstOrNew(['id' => $data['id']]);
            $date->time_id = $data['time_id'];
            $date->user_id = auth()->user()->id;
            $date->status = "wait_accept";
            $date->save();

            return json_encode(["error" => false, "message" => "Ви успішно надіслали запит на прийом до Валерія! Адміністратор зв'яжеться з Вами для підтвердження дати та часу!", "data" => $date]);
        } catch (\Exception $e) {
            file_put_contents("log.txt", $e->getMessage());
            return json_encode(["error" => true, "status"=>-5, "message" => "Something went wrong"]);
        }
    }

    public function accept(Request $request)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $data = json_decode($request->getContent(), true);
        if (!array_key_exists('id', $data)) return json_encode(["error" => true, "message" => 'Запит на запис не знайдено!']);

        try {
            $appointment = ChiefAppointment::where("id", $data['id'])->first();
            $appointment->status = "accepted";
            $appointment->save();
            return json_encode(["error" => false, "message" => 'Час прийому прийнято успішно!']);
        } catch (\Exception $e) {
            return json_encode(["error" => true, "message" => $e->getMessage()]);
        }
    }

    public function reject(Request $request)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $data = json_decode($request->getContent(), true);
        if (!array_key_exists('id', $data)) return json_encode(["error" => true, "message" => 'Запит на запис не знайдено!']);

        try {
            $appointment = ChiefAppointment::where("id", $data['id'])->first();
            $appointment->status = "rejected";
            $appointment->save();
            return json_encode(["error" => false, "message" => 'Час прийому відхилено успішно!']);
        } catch (\Exception $e) {
            return json_encode(["error" => true, "message" => $e->getMessage()]);
        }
    }

    public function userNotes(){
        if(!auth()->user()) return abort(404);

        $notes = DB::table('chief_appointments')
            ->join("calendar_times", "chief_appointments.time_id", "=", "calendar_times.id")
            ->join("users", "chief_appointments.user_id", "=","users.id")
            ->where("users.id", '=', auth()->user()->id)
            ->orderBy("chief_appointments.created_at", "desc")
            ->select(
                'chief_appointments.status as status',
                'chief_appointments.id as id',
                'calendar_times.time as time', 'calendar_times.date as date',
                'chief_appointments.created_at as created_at'
            )
            ->get();


        return $this->view('users.all-user-notes', ['notes'=>$notes]);
    }
}
