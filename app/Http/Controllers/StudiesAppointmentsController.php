<?php

namespace App\Http\Controllers;

use App\Models\StudyAppointment;
use Illuminate\Http\Request;

class StudiesAppointmentsController
{
    public function save(Request $request)
    {
        if (!auth()->check()) return abort(404);
        $data = json_decode($request->getContent(), true);

        if(!array_key_exists('id', $data)) $data['id']='-1';

        try {
            $findedByData = StudyAppointment::where([["id", "!=", $data['id']], "status" => "awaiting_acceptance", "user_id" => $data['user_id'], "study_id" => $data['study_id']])->first();
            if ($findedByData)
                return json_encode(["error" => true, "found_id" => $findedByData['id']]);

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
}
