<?php

namespace App\Http\Controllers;

use App\Models\StudyAppointment;
use Illuminate\Http\Request;

class StudiesAppointmentsController extends Controller
{
    public function save(Request $request)
    {
        if (!auth()->check()) return abort(404);
        $data = json_decode($request->getContent(), true);

        if(!array_key_exists('id', $data)) $data['id']='-1';

        try {
            $findedByData = StudyAppointment::where([["id", "!=", $data['id']], "status" => "wait_accept", "user_id" => $data['user_id'], "study_id" => $data['study_id']])->first();
            if ($findedByData)
                return json_encode(["error" => true, "message" => "Ви вже відправили запит на запис щодо навчання! Зачекайте, поки адміністратор зателефонує Вам для узгодження часу і місця!"]);

            $findedByData = StudyAppointment::where([["id", "!=", $data['id']], "status" => "accepted", "user_id" => $data['user_id'], "study_id" => $data['study_id']])->first();
            if ($findedByData)
                return json_encode(["error" => true, "message" => "Ви вже записані на даний курс навчання!"]);

            $findedByData = StudyAppointment::where([["id", "!=", $data['id']], "status" => "rejected", "user_id" => $data['user_id'], "study_id" => $data['study_id']])->first();
            if ($findedByData)
                return json_encode(["error" => true, "message" => "На жаль, вас не прийнято до курсу, якщо вважаєте, що виникла помилка, зателефонуйте адміністратору!"]);

            $findedByData = StudyAppointment::where(["time_id" => $data['time_id']])->first();
            if($findedByData && $findedByData['id'] == $data['id'] && $findedByData["status"] == $data['status'] && $findedByData["study_id"] == $data['study_id'] && $findedByData["user_id"] == $data['user_id'])
                return json_encode(["error" => false, "message" => ""]);

            $date = StudyAppointment::firstOrNew(['id' => $data['id']]);
            $date->study_id = $data['study_id'];
            $date->user_id = $data['user_id'];
            $date->status = $data['status'];
            $date->save();

            return json_encode(["error" => false, "data" => $date]);
        } catch (\Exception $e) {
            file_put_contents("log.txt", $e->getMessage());
            return json_encode(["error" => true, "message" => "Something went wrong"]);
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

    public function allNotes(){
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        return $this->view('admin.notes-studies');
    }

    public function getNotes(){
        if (!auth()->check() || !auth()->user()->admin) return abort(404);

    }
}
