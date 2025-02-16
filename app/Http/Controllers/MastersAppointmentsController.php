<?php

namespace App\Http\Controllers;

use App\Models\Master;
use App\Models\MasterAppointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MastersAppointmentsController extends Controller
{
    public function save(Request $request)
    {
        if (!auth()->check()) return abort(404);
        $data = json_decode($request->getContent(), true);

        if (!array_key_exists('id', $data)) $data['id'] = '-1';

        try {
            $master = Master::where("id", $data['master_id'])->first();
            if(!$master)
                return json_encode(["error" => true, "status"=>-1, "message" => "Майстра не знайдено!"]);

            $findedByData = MasterAppointment::where([["id", "!=", $data['id']], "status" => "wait_accept", "user_id" => auth()->user()->id, "master_id" => $data['master_id']])->first();
            if ($findedByData)
                return json_encode(["error" => true, "status"=>-2, "message" => "Ви вже відправили запит на запис до майстра! Зачекайте, поки адміністратор зателефонує Вам для узгодження часу і місця!"]);

            $date = MasterAppointment::firstOrNew(['id' => $data['id']]);
            $date->master_id = $data['master_id'];
            $date->user_id = auth()->user()->id;
            $date->status = "wait_accept";
            $date->save();

            return json_encode(["error" => false, "data" => $date]);
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
            $appointment = MasterAppointment::where("id", $data['id'])->first();
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
            $appointment = MasterAppointment::where("id", $data['id'])->first();
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
        return $this->view('admin.notes-masters');
    }

    public function getNotes(Request $request)
    {
        try {
            if (!auth()->check() || !auth()->user()->admin) return abort(404);
            $data = json_decode($request->getContent(), true);
            if (!array_key_exists('search', $data) || !array_key_exists('count', $data) || !array_key_exists('start', $data)) return abort(404);
            $start = intval($data['start']);
            $count = intval($data['count']);
            $search = $data['search'] ?? "";

            $notes = DB::table('masters_appointments')
                ->join("masters", "masters_appointments.master_id", "=", "masters.id")
                ->join("users", "masters_appointments.user_id", "=", "users.id")
                ->where("users.first_name", 'like', '%' . $search . '%')
                ->orWhere("users.last_name", 'like', '%' . $search . '%')
                ->orWhere("masters.first_name", 'like', '%' . $search . '%')
                ->orWhere("masters.last_name", 'like', '%' . $search . '%')
                ->skip($start)
                ->take($count)
                ->select('users.first_name as user_first_name', 'users.last_name as user_last_name',
                    'users.email as user_email', 'users.phone as user_phone',
                    'masters_appointments.id as id', 'masters_appointments.status as status',
                    'masters.first_name as master_first_name', 'masters.last_name as master_last_name'
                )
                ->get();
            return json_encode(["error" => false, "notes" => $notes]);
        } catch (\Exception $e) {
            return json_encode(["error" => true, "message" => $e->getMessage()]);
        }
    }

    public function userNotes(){
        if(!auth()->user()) return abort(404);

        $notes = DB::table('masters_appointments')
            ->join("masters", "masters_appointments.master_id", "=", "masters.id")
            ->join("users", "masters_appointments.user_id", "=","users.id")
            ->where("users.id", '=', auth()->user()->id)
            ->orderBy("masters_appointments.created_at", "desc")
            ->select(
                'masters_appointments.id as id', 'masters_appointments.status as status',
                'masters.first_name as master_first_name', 'masters.last_name as master_last_name',
                'masters_appointments.created_at as created_at'
            )
            ->get();


        return $this->view('users.all-user-notes', ['notes'=>$notes]);
    }

}
