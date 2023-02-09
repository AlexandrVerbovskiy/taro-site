<?php

namespace App\Http\Controllers;

use App\Models\Study;
use App\Models\StudyTopic;
use Illuminate\Http\Request;

class StudiesController extends Controller
{
    public function createTopic()
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        return $this->view('studies.topic-edit');
    }

    public function editTopic(Request $request, $id)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $topic = StudyTopic::where('id', '=', $id)->first();

        if(!$topic) return abort(404);

        return $this->view('studies.topic-edit', [
            'title_ua' => $topic->title_ua,
            'title_ru' => $topic->title_ru,
            'id' => $topic->id
        ]);
    }

    public function saveTopic(Request $request)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);

        $data = $request->input();

        if (!array_key_exists('id', $data)) {
            $data['id'] = '-1';
        }

        try {
            $findedByData = StudyTopic::where([["id", "!=", $data['id']], "title_ru" => $data['title_ru']], ['id' ,'!=',$data['id']])->first();
            if (!isset($findedByData)) {
                $findedByData = StudyTopic::where([["id", "!=", $data['id']], "title_ua" => $data['title_ua'], ['id' ,'!=',$data['id']]])->first();
            }

            if ($findedByData)
                return back()->withInput(\Illuminate\Support\Facades\Request::except(''))->withErrors([
                    'founded_id' => 'id'
                ]);

            $findedByData = StudyTopic::where(["title_ru" => $data['title_ru']], ['id' ,'!=',$data['id']])->first();
            if ($findedByData && $data['title_ua'] == $findedByData['title_ua'] && $data['title_ru'] == $findedByData['title_ru'])
                return back()->withInput(\Illuminate\Support\Facades\Request::except(''));

            $topic = StudyTopic::firstOrNew(['id' => $data['id']]);
            $topic->title_ua = $data['title_ua'];
            $topic->title_ru = $data['title_ru'];
            $topic->save();

            return redirect()->to('/admin/edit-study-topic/' . $topic->id);
        } catch (\Exception $e) {
            file_put_contents("log.txt", $e->getMessage());
            return back()->withInput(\Illuminate\Support\Facades\Request::except(''))->withErrors([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function deleteTopic(Request $request){
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $data = json_decode($request->getContent(), true);
        if (!array_key_exists('id', $data)) return json_encode(["error" => true, "message" => 'Topic wasn\'t find']);

        try {
            StudyTopic::where("id", $data['id'])->delete();
            return json_encode(["error" => false, "message" => 'Deleted success']);
        } catch (\Exception $e) {
            return json_encode(["error" => true, "message" => $e->getMessage()]);
        }
    }

    public function changeVisibleTopic(Request $request){
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $data = json_decode($request->getContent(), true);
        if (!array_key_exists('id', $data)) return json_encode(["error" => true, "message" => 'Topic wasn\'t find']);

        try {
            return json_encode(["error" => false, "message" => 'Success']);
        } catch (\Exception $e) {
            return json_encode(["error" => true, "message" => $e->getMessage()]);
        }
    }






    public function createStudy()
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $studies = StudyTopic::all();
        return $this->view('studies.study-edit', ['studies' => $studies]);
    }

    public function editStudy(Request $request, $id)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $studies = StudyTopic::all();
        $study = Study::where('id', '=', $id)->first();

        if (!$study) return abort(404);

        return $this->view('studies.study-edit', [
            'studies' => $studies,
            'id' => $study->id,
            'body' => $study->body,
            'title' => $study->title,
            'topic_id' => $study->topic_id,
            'date' => $study->date
        ]);
    }

    public function saveStudy(Request $request)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);

        $data = $request->input();

        if (!array_key_exists('id', $data)) {
            $data['id'] = '-1';
        }

        try {
            $findedByData = Study::where(["title" => $data['title'], "date" => $data['date'], "topic_id" => $data['topic_id']])->first();
            if ($findedByData && $findedByData['id'] != $data['id'])
                return back()->withInput(\Illuminate\Support\Facades\Request::except(''))->withErrors([
                    'founded_id' => 'id'
                ]);

            if ($findedByData && $data['body'] == $findedByData['body'] && $data['title'] == $findedByData['title'] && $findedByData['id'] == $data['id'] && $data['date'] == $findedByData['date'] && $data['id_studies_topic'] == $findedByData['id_studies_topic'])
                return back()->withInput(\Illuminate\Support\Facades\Request::except(''));

            $study = Study::firstOrNew(['id' => $data['id']]);
            $study->body = $data['body'];
            $study->title = $data['title'];
            $study->topic_id = $data['topic_id'];
            $study->date = $data['date'];
            $study->save();

            return redirect()->to('/admin/edit-study/' .$study->id);
        } catch (\Exception $e) {
            file_put_contents("log.txt", $e->getMessage());
            return back()->withInput(\Illuminate\Support\Facades\Request::except(''))->withErrors([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function topics()
    {
        $topics = StudyTopic::all();
        return $topics;
    }

    public function studies(Request $request, $id)
    {
        $posts_count = Study::where("topic_id", $id)->count();
        return $this->view("studies.index", ['count' => $posts_count, 'topic_id'=>$id]);
    }

    public function getStudies()
    {
        if (!is_numeric($_GET['start']) || !is_numeric($_GET['count'])) return json_encode(["error" => false, "events" => []]);

        $start = intval($_GET['start']);
        $count = intval($_GET['count']);
        $search = $_GET['search']??"";

        if (array_key_exists('topic', $_GET) && is_numeric($_GET['topic']))
            return json_encode(["error" => false, "studies" => Study::where("topic_id", $_GET['topic'])
                ->where("title", 'like', '%'.$search.'%')
                ->skip($start)
                ->take($count)
                ->get()]);
        else
            return json_encode(["error" => false, "studies" => Study::where("title", 'like', '%'.$search.'%')->skip($start)->take($count)->get()]);

    }

    public function deleteStudy(Request $request){
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $data = json_decode($request->getContent(), true);
        if (!array_key_exists('id', $data)) return json_encode(["error" => true, "message" => 'Event post wasn\'t find']);

        try {
            Study::where("id", $data['id'])->delete();
            return json_encode(["error" => false, "message" => 'Deleted success']);
        } catch (\Exception $e) {
            return json_encode(["error" => true, "message" => $e->getMessage()]);
        }
    }

    public function changeVisibleStudy(Request $request){
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $data = json_decode($request->getContent(), true);
        if (!array_key_exists('id', $data)) return json_encode(["error" => true, "message" => 'Event post wasn\'t find']);

        try {
            return json_encode(["error" => false, "message" => 'Success']);
        } catch (\Exception $e) {
            return json_encode(["error" => true, "message" => $e->getMessage()]);
        }
    }
}
