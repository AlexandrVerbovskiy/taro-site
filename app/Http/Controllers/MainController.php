<?php

namespace App\Http\Controllers;

use App\Models\Acivity;
use App\Models\Event;
use App\Models\EventTopic;
use App\Models\Info;
use App\Models\Master;
use App\Models\StudyTopic;
use App\Models\User;

class MainController extends Controller
{
    public function home()
    {
        return $this->view("welcome");
    }

    public function admin()
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        return view("admin.main");
    }

    public function masters()
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $masters = Master::all();
        return view("admin.masters", ['masters' => $masters]);
    }

    public function activities()
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $activities = Acivity::all();
        return view("admin.activities", ['activities' => $activities]);
    }

    public function infos(){
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $infos = Info::all();
        return view("admin.infos", ['infos' => $infos]);
    }

    public function studiesTopics(){
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $topics = StudyTopic::all();
        return view("admin.studies-topics", ['topics' => $topics]);
    }

    public function eventsTopics(){
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $topics = EventTopic::all();
        return view("admin.events-topics", ['topics' => $topics]);
    }

    public function users()
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        return view("admin.users", ['count' => User::all()->count()]);
    }

    public function events()
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        return $this->view("admin.events", ['count' => Event::all()->count()]);
    }
}
