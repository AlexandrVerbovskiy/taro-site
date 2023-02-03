<?php

namespace App\Http\Controllers;

use App\Models\MasterAppointment;
use Illuminate\Http\Request;

class MastersAppointmentsController extends Controller
{
    public function save(Request $request)
    {
        if (!auth()->check()) return abort(404);
        $data = json_decode($request->getContent(), true);

        if(!array_key_exists('id', $data)) $data['id']='-1';

        try {
            $findedByData = MasterAppointment::where([["id", "!=", $data['id']], "status" => "awaiting_acceptance", "user_id" => $data['user_id'], "master_id" => $data['master_id']])->first();
            if ($findedByData)
                return json_encode(["error" => true, "found_id" => $findedByData['id']]);

            $findedByData = MasterAppointment::where(["time_id" => $data['time_id']])->first();
            if($findedByData && $findedByData['id'] == $data['id'] && $findedByData["status"] == $data['status'] && $findedByData["master_id"] == $data['master_id'] && $findedByData["user_id"] == $data['user_id'])
                return json_encode(["error" => false, "message" => ""]);

            $date = MasterAppointment::firstOrNew(['id' => $data['id']]);
            $date->master_id = $data['master_id'];
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
