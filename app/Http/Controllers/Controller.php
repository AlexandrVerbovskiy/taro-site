<?php

namespace App\Http\Controllers;

use App\Models\Acivity;
use App\Models\EventTopic;
use App\Models\StudyTopic;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Contracts\View\Factory as ViewFactory;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function view($view = null, $data = [], $mergeData = [])
    {
        $factory = app(ViewFactory::class);

        if (func_num_args() === 0) {
            return $factory;
        }

        $events_topics = EventTopic::all();
        $studies_topics = StudyTopic::all();
        $activities = Acivity::all(["id", "title_ua", "title_ru", "type"]);
        $temp = ["events_topics"=>$events_topics, "studies_topics"=>$studies_topics, "activities_topics"=>$activities];
        $data = array_merge($data, $temp);

        return $factory->make($view, $data, $mergeData);
    }
}
