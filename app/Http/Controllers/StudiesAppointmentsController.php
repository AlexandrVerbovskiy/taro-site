<?php

namespace App\Http\Controllers;

use App\Models\Study;
use App\Models\StudyAppointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudiesAppointmentsController extends Controller
{
    public function save(Request $request)
    {
        if (!auth()->check()) return abort(404);
        $data = json_decode($request->getContent(), true);

        if (!array_key_exists('id', $data)) $data['id'] = '-1';

        try {
            $study = Study::where("id", $data["study_id"])->first();
            if (!$study) return json_encode(["error" => true, "status" => -1, "message" => "Навчання не знайдено!"]);


            $findedByData = StudyAppointment::where([["id", "!=", $data['id']], "status" => "wait_accept", "user_id" => auth()->user()->id, "study_id" => $data['study_id']])->first();
            if ($findedByData)
                return json_encode(["error" => true, "status" => -2, "message" => "Ви вже відправили запит на запис щодо навчання! Зачекайте, поки адміністратор зателефонує Вам для узгодження часу і місця!"]);

            $findedByData = StudyAppointment::where([["id", "!=", $data['id']], "status" => "accepted", "user_id" => auth()->user()->id, "study_id" => $data['study_id']])->first();
            if ($findedByData)
                return json_encode(["error" => true, "status" => -3, "message" => "Ви вже записані на даний курс навчання!"]);

            $findedByData = StudyAppointment::where([["id", "!=", $data['id']], "status" => "rejected", "user_id" => auth()->user()->id, "study_id" => $data['study_id']])->first();
            if ($findedByData)
                return json_encode(["error" => true, "status" => -4, "message" => "На жаль, вас не прийнято до курсу, якщо вважаєте, що виникла помилка, зателефонуйте адміністратору!"]);

            $date = StudyAppointment::firstOrNew(['id' => $data['id']]);
            $date->study_id = $data['study_id'];
            $date->user_id = auth()->user()->id;
            $date->status = "wait_accept";
            $date->save();

            return json_encode(["error" => false, "data" => $date]);
        } catch (\Exception $e) {
            file_put_contents("log.txt", $e->getMessage());
            return json_encode(["error" => true, "status" => -5, "message" => "Something went wrong"]);
        }
    }

    public function accept(Request $request)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $data = json_decode($request->getContent(), true);
        if (!array_key_exists('id', $data)) return json_encode(["error" => true, "message" => 'Запит на запис не знайдено!']);

        try {
            $appointment = StudyAppointment::where("id", $data['id'])->first();
            $appointment->status = "accepted";
            $appointment->save();
            return json_encode(["error" => false, "message" => 'Запит на запис прийнято успішно!']);
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
            $appointment = StudyAppointment::where("id", $data['id'])->first();
            $appointment->status = "rejected";
            $appointment->save();
            return json_encode(["error" => false, "message" => 'Запит на запис  відхилено успішно!']);
        } catch (\Exception $e) {
            return json_encode(["error" => true, "message" => $e->getMessage()]);
        }
    }

    public function allNotes()
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        return $this->view('admin.notes-studies');
    }

    public function getNotes(Request $request)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $data = json_decode($request->getContent(), true);
        if (!array_key_exists('search', $data) || !array_key_exists('count', $data) || !array_key_exists('start', $data)) return abort(404);
        $start = intval($data['start']);
        $count = intval($data['count']);
        $search = $data['search'] ?? "";

        return json_encode(["error" => false, "notes" => DB::table('studies_appointments')
            ->join("studies", "studies_appointments.study_id", "=", "studies.id")
            ->join("users", "studies_appointments.user_id", "=", "users.id")
            ->where("users.first_name", 'like', '%' . $search . '%')
            ->orWhere("users.last_name", 'like', '%' . $search . '%')
            ->orWhere("studies.title", 'like', '%' . $search . '%')
            ->skip($start)
            ->take($count)
            ->select('users.first_name as user_first_name', 'users.last_name as user_last_name',
                'users.email as user_email', 'users.phone as user_phone',
                'studies_appointments.id as id',
                'studies.title as study_title', 'studies_appointments.status as status',
            )
            ->get()]);
    }

    public function userNotes()
    {
        if (!auth()->user()) return abort(404);

        $notes = DB::table('studies_appointments')
            ->join("studies", "studies_appointments.study_id", "=", "studies.id")
            ->join("users", "studies_appointments.user_id", "=", "users.id")
            ->where("users.id", '=', auth()->user()->id)
            ->orderBy("studies_appointments.created_at", "desc")
            ->select(
                'studies_appointments.id as id',
                'studies.title as study_title', 'studies_appointments.status as status',
                'studies_appointments.created_at as created_at'
            )
            ->get();


        return $this->view('users.all-user-notes', ['notes' => $notes]);
    }
}
