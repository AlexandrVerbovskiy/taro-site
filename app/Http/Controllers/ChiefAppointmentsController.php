<?php

namespace App\Http\Controllers;

use App\Models\ChiefAppointment;
use Illuminate\Http\Request;

class ChiefAppointmentsController
{
    public function save(Request $request)
    {
        if (!auth()->check()) return abort(404);
        $data = json_decode($request->getContent(), true);

        if(!array_key_exists('id', $data)) $data['id']='-1';

        try {
            $findedByData = ChiefAppointment::where([["id", "!=", $data['id']],"time_id" => $data['time_id']])->first();
            if ($findedByData)
                return json_encode(["error" => true, "found_id" => $findedByData['id']]);

            $findedByData = ChiefAppointment::where(["time_id" => $data['time_id']])->first();
            if($findedByData && $findedByData['id'] == $data['id'] && $findedByData["time_id"] == $data['time_id'] && $findedByData["status"] == $data['status'])
                return json_encode(["error" => false, "message" => ""]);

            $date = ChiefAppointment::firstOrNew(['id' => $data['id']]);
            $date->time_id = $data['time_id'];
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
