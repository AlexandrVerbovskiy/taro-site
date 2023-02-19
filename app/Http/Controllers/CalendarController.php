<?php

namespace App\Http\Controllers;

use App\Models\CalendarDate;
use App\Models\CalendarTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalendarController extends Controller
{
    public function saveTimeCalendar(Request $request){
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $data = json_decode($request->getContent(), true);

        if(!array_key_exists('id', $data)) $data['id']='-1';

        try {
            $findedByData = CalendarTime::where([["id", "!=", $data['id']], "time" => $data['time'].":00", "date" => $data['date']])->first();
            if ($findedByData) return json_encode(["error" => true, "message" => "Ви не можете додати запис на цей час, так як він уже існує!"]);

            $findedByData = CalendarTime::where(["time" => $data['time'], "date" => $data['date']])->first();
            if ($findedByData && $findedByData['id'] == $data['id'] && $findedByData["date"] == $data['date'] && $findedByData["time"] == $data['time'])
                return json_encode(["error" => false, "message" => ""]);


            $date = CalendarTime::firstOrNew(['id' => $data['id']]);
            $date->time = $data['time'];
            $date->date = $data['date'];
            $date->save();

            return json_encode(["error" => false, "data" => $date]);
        } catch (\Exception $e) {
            file_put_contents("log.txt", $e->getMessage());
            return json_encode(["error" => true, "message" => "Something went wrong"]);
        }
    }

    public function getTimes(Request $request, $date){
       try{        $times = CalendarTime::where('date', '=', $date)->orderBy("time")->get();
        return json_encode(["error" => false, "date"=>$date,  "times" => $times]);
       } catch (\Exception $e) {
           file_put_contents("log.txt", $e->getMessage());
           return json_encode(["error" => true, "message" => $e->getMessage()]);
       }
    }

    public function delete(Request $request){
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $data = json_decode($request->getContent(), true);
        if (!array_key_exists('id', $data)) return json_encode(["error" => true, "message" => 'Час прийому не знайдено!']);

        try {
            CalendarTime::where("id", $data['id'])->delete();
            return json_encode(["error" => false, "message" => 'Час прийому видалено успішно!']);
        } catch (\Exception $e) {
            return json_encode(["error" => true, "message" => $e->getMessage()]);
        }
    }
}
