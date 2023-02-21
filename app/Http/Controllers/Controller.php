<?php

namespace App\Http\Controllers;

use App\Models\Acivity;
use App\Models\EventTopic;
use App\Models\Info;
use App\Models\StudyTopic;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function view($view = null, $data = [], $mergeData = [])
    {
        $factory = app(ViewFactory::class);

        if (func_num_args() === 0) {
            return $factory;
        }

        $events_topics = EventTopic::where("hidden", false)->get();
        $studies_topics = StudyTopic::where("hidden", false)->get();
        $infos = Info::where("hidden", false)->get();
        $activities = Acivity::where("hidden", false)->get(["id", "title_ua", "title_ru", "type"]);
        $temp = ["events_topics" => $events_topics, "infos" => $infos, "studies_topics" => $studies_topics, "activities_topics" => $activities];
        $data = array_merge($data, $temp);

        return $factory->make($view, $data, $mergeData);
    }

    public function getActualUserNotesToBoss(){
        if(!auth()->user()) return null;
        $findedByData = DB::table('chief_appointments')
            ->join("calendar_times", "calendar_times.id", "=", "chief_appointments.time_id")
            ->whereRaw("chief_appointments.user_id = " . auth()->user()->id . " AND (status = 'wait_accept' or status = 'accepted') AND cast(concat(calendar_times.date, ' ', calendar_times.time) as datetime) > CURRENT_TIMESTAMP()")
            ->select("calendar_times.*", "chief_appointments.*")
            ->first();
        return $findedByData;
    }
}
