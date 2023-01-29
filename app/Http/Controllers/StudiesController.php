<?php

namespace App\Http\Controllers;

use App\Models\Study;
use App\Models\StudyTopic;
use Illuminate\Http\Request;

class StudiesController
{
    public function createTopic()
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        return view('studies.topic-edit');
    }

    public function editTopic(Request $request, $id)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $topic = StudyTopic::where('id', '=', $id)->first();

        if(!$topic) return abort(404);

        return view('studies.topic-edit', [
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
            $findedByData = StudyTopic::where(["title_ru" => $data['title_ru']], ['id' ,'!=',$data['id']])->first();
            if (!isset($findedByData)) {
                $findedByData = StudyTopic::where(["title_ua" => $data['title_ua'], ['id' ,'!=',$data['id']]])->first();
            }
            if ($findedByData && $findedByData['id'] != $data['id'])
                return back()->withInput(\Illuminate\Support\Facades\Request::except(''))->withErrors([
                    'founded_id' => 'id'
                ]);

            if ($findedByData && $findedByData['id'] == $data['id'] && $data['title_ua'] == $findedByData['title_ua'] && $data['title_ru'] == $findedByData['title_ru'])
                return back()->withInput(\Illuminate\Support\Facades\Request::except(''));

            $topic = StudyTopic::firstOrNew(['id' => $data['id']]);
            $topic->title_ua = $data['title_ua'];
            $topic->title_ru = $data['title_ru'];
            $topic->save();

            return redirect()->to('/');
        } catch (\Exception $e) {
            file_put_contents("log.txt", $e->getMessage());
            return back()->withInput(\Illuminate\Support\Facades\Request::except(''))->withErrors([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function createStudy()
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $studies = StudyTopic::all();
        return view('studies.study-edit', ['studies' => $studies]);
    }

    public function editStudy(Request $request, $id)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $studies = StudyTopic::all();
        $study = Study::where('id', '=', $id)->first();

        if (!$study) return abort(404);

        return view('studies.study-edit', [
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

            $topic = Study::firstOrNew(['id' => $data['id']]);
            $topic->body = $data['body'];
            $topic->title = $data['title'];
            $topic->topic_id = $data['topic_id'];
            $topic->date = $data['date'];
            $topic->save();

            return redirect()->to('/');
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

    public function studies(Request $request, $topic_id)
    {
        $studies = Study::where(['topic_id' => $topic_id])->get();
        return $studies;
    }

    public function study(Request $request, $study_id)
    {
        $study = Study::where(['id' => $study_id])->first();
        return $study;
    }
}
