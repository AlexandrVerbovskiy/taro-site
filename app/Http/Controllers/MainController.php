<?php

namespace App\Http\Controllers;

use App\Models\Acivity;
use App\Models\Event;
use App\Models\EventTopic;
use App\Models\Info;
use App\Models\InfoPost;
use App\Models\Master;
use App\Models\StaticModel;
use App\Models\Study;
use App\Models\StudyTopic;
use App\Models\User;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function home()
    {
        $main_img = StaticModel::where("key", "main_image")->first();
        $main_img = $main_img? $main_img->value:"";

        $main_body = StaticModel::where("key", "main_body")->first();
        $main_body = $main_body? $main_body->value:"";
        return $this->view("welcome", ['main_img'=>$main_img, 'main_body'=>$main_body]);
    }

    public function admin()
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $statistic = [];
        $statistic['count_all_users'] = User::count();
        $statistic['count_users'] = User::where("admin", false)->count();
        $statistic['count_admins'] = User::where("admin", true)->count();
        $statistic['count_events'] = Event::count();
        $statistic['count_showed_events'] = Event::where("hidden", false)->count();
        $statistic['count_masters'] = Master::count();
        $statistic['count_showed_master'] = Master::where("hidden", false)->count();
        $statistic['count_activities'] = Acivity::count();
        $statistic['count_showed_activities'] = Acivity::where("hidden", false)->count();
        $statistic['count_infos_posts'] = InfoPost::count();
        $statistic['count_showed_infos_posts'] = InfoPost::where("hidden", false)->count();
        $statistic['count_studies'] = Study::count();
        $statistic['count_showed_studies'] = Study::where("hidden", false)->count();
        return view("admin.main", ["statistic"=>$statistic]);
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

    public function infosPosts(){
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        return $this->view("admin.infos-posts", ['count' => InfoPost::all()->count()]);
    }

    public function getInfosPosts()
    {
        if (!is_numeric($_GET['start']) || !is_numeric($_GET['count'])) return json_encode(["error" => false, "events" => []]);

        $start = intval($_GET['start']);
        $count = intval($_GET['count']);
        $search = $_GET['search'] ?? "";

        return json_encode(["error" => false, "posts" => InfoPost::where("title", 'like', '%' . $search . '%')
            ->skip($start)
            ->take($count
            )->get()]);
    }

    public function events()
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        return $this->view("admin.events", ['count' => Event::all()->count()]);
    }

    public function getEvents()
    {
        if (!is_numeric($_GET['start']) || !is_numeric($_GET['count'])) return json_encode(["error" => false, "events" => []]);

        $start = intval($_GET['start']);
        $count = intval($_GET['count']);
        $search = $_GET['search'] ?? "";

        return json_encode(["error" => false, "events" => Event::where("title", 'like', '%'.$search.'%')
            ->skip($start)
            ->take($count)
            ->get()]);
    }

    public function studies(){
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        return $this->view("admin.studies", ['count' => Study::all()->count()]);
    }

    public function getStudies(){
        if (!is_numeric($_GET['start']) || !is_numeric($_GET['count'])) return json_encode(["error" => false, "events" => []]);

        $start = intval($_GET['start']);
        $count = intval($_GET['count']);
        $search = $_GET['search']??"";

        return json_encode(["error" => false, "studies" => Study::where("title", 'like', '%'.$search.'%')
            ->skip($start)
            ->take($count)
            ->get()]);
    }

    public function mainPageSettings(){
        if (!auth()->check() || !auth()->user()->admin) return abort(404);

        $main_img = StaticModel::where("key", "main_image")->first();
        $main_img = $main_img? $main_img->value:"";

        $main_body = StaticModel::where("key", "main_body")->first();
        $main_body = $main_body? $main_body->value:"";
        return $this->view("admin.main-settings", ['main_img'=>$main_img, 'main_body'=>$main_body]);
    }

    public function saveMain(Request $request){
        if (!auth()->check() || !auth()->user()->admin) return abort(404);

        $data = $request->input();
        if (!array_key_exists('main_img', $data) || !array_key_exists('main_body', $data)){
            return back()->withInput(\Illuminate\Support\Facades\Request::except(''))->withErrors("Any property can'r be empty!");
        }

        $main_img = StaticModel::where("key", "main_image")->first();
        $main_img->value = $data['main_img'];
        $main_body = StaticModel::where("key", "main_body")->first();
        $main_body->value = $data['main_body'];
        $main_img->save();
        $main_body->save();
        return redirect()->to('/admin/main-settings/');
    }
}
