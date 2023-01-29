<?php

namespace App\Http\Controllers;

use App\Models\CalendarDate;
use App\Models\CalendarTime;
use Illuminate\Http\Request;

class CalendarController
{
    public function edit(){
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $dates = CalendarDate::all();
        return view('calendar.edit', ['dates'=>$dates]);
    }

    public function saveDateCalendar(Request $request){
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $data = json_decode($request->getContent(), true);

        if(!array_key_exists('id', $data)) $data['id']='-1';

        try {
            $findedByData = CalendarDate::where(["date" => $data['date']])->first();
            if ($findedByData && $findedByData['id'] != $data['id']) {
                return json_encode(["error" => true, "found_id" => $findedByData['id']]);
            } else if ($findedByData && $findedByData['id'] == $data['id'] && $findedByData["date"] == $data['date']) {
                return json_encode(["error" => false, "message" => ""]);
            }

            $date = CalendarDate::firstOrNew(['id' => $data['id']]);
            $date->date = $data['date'];
            $date->save();

            return json_encode(["error" => false, "data" => $date]);
        } catch (\Exception $e) {
            file_put_contents("log.txt", $e->getMessage());
            return json_encode(["error" => true, "message" => "Something went wrong"]);
        }
    }

    public function saveTimeCalendar(Request $request){
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $data = json_decode($request->getContent(), true);

        if(!array_key_exists('id', $data)) $data['id']='-1';

        try {
            $findedByData = CalendarTime::where(["time" => $data['time'], 'calendar_date_id'=>$data['calendar_date_id']])->first();
            if ($findedByData && $findedByData['id'] != $data['id']) {
                return json_encode(["error" => true, "found_id" => $findedByData['id']]);
            } else if ($findedByData && $findedByData['id'] == $data['id'] && $findedByData["calendar_date_id"] == $data['calendar_date_id'] && $findedByData["time"] == $data['time']) {
                return json_encode(["error" => false, "message" => ""]);
            }

            $date = CalendarTime::firstOrNew(['id' => $data['id']]);
            $date->time = $data['time'];
            $date->calendar_date_id = $data['calendar_date_id'];
            $date->save();

            return json_encode(["error" => false, "data" => $date]);
        } catch (\Exception $e) {
            file_put_contents("log.txt", $e->getMessage());
            return json_encode(["error" => true, "message" => "Something went wrong"]);
        }
    }

    public function getTimes(Request $request, $date_id){
        $times = CalendarTime::where('calendar_date_id', '=', $date_id)->get();
        return json_encode($times);
    }
}
