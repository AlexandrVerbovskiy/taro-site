<?php

namespace App\Http\Controllers;

use App\Models\Acivity;
use App\Models\CalendarTime;
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
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function home()
    {
        $main_img = StaticModel::where("key", "main_image")->first();
<<<<<<< HEAD
        $main_img = $main_img? $main_img->value:"";

        $main_body = StaticModel::where("key", "main_body")->first();
        $main_body = $main_body? $main_body->value:"";
        return $this->view("welcome", ['main_img'=>$main_img, 'main_body'=>$main_body]);
=======
        $main_img = $main_img ? $main_img->value : "";

        $main_body = StaticModel::where("key", "main_body")->first();
        $main_body = $main_body ? $main_body->value : "";

        $dates = DB::table("calendar_times")
            ->leftJoin("chief_appointments", "chief_appointments.time_id", "=", "calendar_times.id")
            ->whereRaw("(chief_appointments.id is NULL or chief_appointments.status='rejected') and cast(concat(date, ' ', time) as datetime) > CURRENT_TIMESTAMP()")
            ->select("calendar_times.date")
            ->groupBy('calendar_times.date')
            ->get();

        $filtered_dates = [];
        foreach ($dates as $date) {
            $filtered_dates[] = $date->date;
        }

        $findedNoteToBoss = $this->getActualUserNotesToBoss();

        return $this->view("welcome", ['main_img' => $main_img, 'main_body' => $main_body, "finded_note" => $findedNoteToBoss, "dates" => $filtered_dates]);
>>>>>>> fa4314e1fa79a775cf1e52aa163e445d19091781
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
        return view("admin.main", ["statistic" => $statistic]);
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

    public function infos()
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $infos = Info::all();
        return view("admin.infos", ['infos' => $infos]);
    }

    public function studiesTopics()
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $topics = StudyTopic::all();
        return view("admin.studies-topics", ['topics' => $topics]);
    }

    public function eventsTopics()
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $topics = EventTopic::all();
        return view("admin.events-topics", ['topics' => $topics]);
    }

    public function users()
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        return view("admin.users", ['count' => User::all()->count()]);
    }

    public function infosPosts()
    {
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

        return json_encode(["error" => false, "events" => Event::where("title", 'like', '%' . $search . '%')
            ->skip($start)
            ->take($count)
            ->get()]);
    }

    public function studies()
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        return $this->view("admin.studies", ['count' => Study::all()->count()]);
    }

    public function getStudies()
    {
        if (!is_numeric($_GET['start']) || !is_numeric($_GET['count'])) return json_encode(["error" => false, "events" => []]);

        $start = intval($_GET['start']);
        $count = intval($_GET['count']);
        $search = $_GET['search'] ?? "";

        return json_encode(["error" => false, "studies" => Study::where("title", 'like', '%' . $search . '%')
            ->skip($start)
            ->take($count)
            ->get()]);
    }

<<<<<<< HEAD
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
            return back()->withInput(\Illuminate\Support\Facades\Request::except(''))->withErrors("Жодне поле не може бути порожнім!");
        }

        $main_img = StaticModel::where("key", "main_image")->first();
        $main_img->value = $data['main_img'];
        $main_body = StaticModel::where("key", "main_body")->first();
        $main_body->value = $data['main_body'];
        $main_img->save();
        $main_body->save();
        return redirect()->to('/admin/main-settings/')->with('success', 'Дані збережено успішно!');
    }

    public function comments(){
=======
    public function mainPageSettings()
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);

        $main_img = StaticModel::where("key", "main_image")->first();
        $main_img = $main_img ? $main_img->value : "";

        $main_body = StaticModel::where("key", "main_body")->first();
        $main_body = $main_body ? $main_body->value : "";
        return $this->view("admin.main-settings", ['main_img' => $main_img, 'main_body' => $main_body]);
    }

    public function saveMain(Request $request)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);

        $data = $request->input();
        if (!array_key_exists('main_img', $data) || !array_key_exists('main_body', $data)
            || !$data['main_body'] || strlen($data['main_body']) < 1
            || !$data['main_img'] || strlen($data['main_img']) < 1
        ) return back()->withInput(\Illuminate\Support\Facades\Request::except(''))->withErrors("Жодне поле не може бути порожнім!");

        try {
            $main_img = StaticModel::where("key", "main_image")->first();
            $main_img->value = $data['main_img'];
            $main_body = StaticModel::where("key", "main_body")->first();
            $main_body->value = $data['main_body'];
            $main_img->save();
            $main_body->save();
            return redirect()->to('/admin/main-settings/')->with('success', 'Дані збережено успішно!');
        } catch (\Exception $e) {
            file_put_contents("log.txt", $e->getMessage());
            return back()->withInput(\Illuminate\Support\Facades\Request::except(''))->withErrors([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function comments()
    {
>>>>>>> fa4314e1fa79a775cf1e52aa163e445d19091781
        return view("admin.comments");
    }

    public function getComments(Request $request)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        if (!array_key_exists('search', $_GET) || !array_key_exists('count', $_GET) || !array_key_exists('start', $_GET)) return abort(404);

        try {
            $comments = DB::table('masters_comments')
                ->join('masters', 'masters.id', '=', 'masters_comments.master_id')
                ->join('users', 'users.id', '=', 'masters_comments.author_id')
                ->where("body", 'like', "%{$_GET['search']}%")
                ->orWhere("masters.first_name", 'like', "%{$_GET['search']}%")
                ->orWhere("masters.last_name", 'like', "%{$_GET['search']}%")
                ->orWhere("users.first_name", 'like', "%{$_GET['search']}%")
                ->orWhere("users.last_name", 'like', "%{$_GET['search']}%")
                ->skip($_GET['start'])
                ->take($_GET['count'])
                ->select('masters_comments.id as id', 'masters_comments.body as body',
                    'masters.id as master_id', 'masters.first_name as master_first_name',
                    'masters.last_name as master_last_name',
                    'users.first_name as user_first_name',
                    'users.last_name as user_last_name',
                )
                ->get();
            return json_encode(["error" => false, "comments" => $comments]);
        } catch (\Exception $e) {
            file_put_contents("log.txt", $e->getMessage());
            return json_encode(["error" => true, "message" => $e->getMessage()]);
        }
    }
<<<<<<< HEAD
=======

    public function getTimes(Request $request, $date)
    {
        try {
            $times = DB::table("calendar_times")
                ->leftJoin("chief_appointments", "chief_appointments.time_id", "=", "calendar_times.id")
                ->leftJoin("users", "chief_appointments.user_id", "=", "users.id")
                ->whereRaw("date='$date' and (chief_appointments.id is NULL or chief_appointments.status!='rejected')")
                ->orderBy("time")
                ->get();
            return json_encode(["error" => false, "date" => $date, "times" => $times]);
        } catch (\Exception $e) {
            file_put_contents("log.txt", $e->getMessage());
            return json_encode(["error" => true, "message" => $e->getMessage()]);
        }
    }

    public function calendar()
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        return $this->view("admin.calendar");
    }
>>>>>>> fa4314e1fa79a775cf1e52aa163e445d19091781
}
