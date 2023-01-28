<?php

namespace App\Http\Controllers;

use App\Models\Acivity;
use App\Models\Study;
use App\Models\StudyTopic;
use Illuminate\Http\Request;

class StudiesController
{
    public function createTopic(){
        if (!auth()->user()->admin) return redirect()->to('/');
        return view('studies.topic-edit');
    }

    public function saveTopic(Request $request){
        if (!auth()->user()->admin) return redirect()->to('/');

        $data = $request->input();

        if(!array_key_exists('id', $data)) {
            $data['id'] = '-1';
        }

        try {
            $findedByData = StudyTopic::where(["title_ru" => $data['title_ru']])->first();
            if(!$findedByData){
                $findedByData = StudyTopic::where(["title_ua" => $data['title_ua']])->first();
            }
            if ($findedByData && $findedByData['id'] != $data['id'])
                return json_encode(["error" => true, "founded_id" => $findedByData['id']]);

            if ($findedByData && $findedByData['id'] == $data['id'] && $data['title_ua'] == $findedByData['title_ua'] && $data['title_ru'] == $findedByData['title_ru'])
                return json_encode(["error" => false]);

            $topic = StudyTopic::firstOrNew(['id' => $data['id']]);
            $topic->title_ua = $data['title_ua'];
            $topic->title_ru = $data['title_ru'];
            $topic->save();

            return redirect()->to('/');
        } catch (\Exception $e) {
            file_put_contents("log.txt", $e->getMessage());
            return redirect()->to('/');
        }
    }

    public function createStudy(){
        if (!auth()->user()->admin) return redirect()->to('/');
        $studies = StudyTopic::all();
        return view('studies.study-edit', ['studies'=>$studies]);
    }

    public function saveStudy(Request $request){
        if (!auth()->user()->admin) return redirect()->to('/');

        $data = $request->input();

        if(!array_key_exists('id', $data)) {
            $data['id'] = '-1';
        }

        //try {
            $findedByData = Study::where(["date" => $data['date'], "topic_id" => $data['topic_id']])->first();
            if ($findedByData && $findedByData['id'] != $data['id'])
                return json_encode(["error" => true, "founded_id" => $findedByData['id']]);

            if ($findedByData && $data['body'] == $findedByData['body'] &&  $data['title'] == $findedByData['title'] && $findedByData['id'] == $data['id'] && $data['date'] == $findedByData['date'] && $data['id_studies_topic'] == $findedByData['id_studies_topic'])
                return json_encode(["error" => false]);

            $topic = Study::firstOrNew(['id' => $data['id']]);
            $topic->body = $data['body'];
            $topic->title = $data['title'];
            $topic->topic_id = $data['topic_id'];
            $topic->date = $data['date'];
            $topic->save();

            return redirect()->to('/');
        /*} catch (\Exception $e) {
            file_put_contents("log.txt", $e->getMessage());
            return redirect()->to('/');
        }*/
    }

    public function topics(){
        $topics = StudyTopic::all();
        return $topics;
    }

    public function studies(Request $request, $topic_id){
        $studies = Study::where(['topic_id'=>$topic_id])->get();
        return $studies;
    }

    public function study(Request $request, $study_id){
        $study = Study::where(['id'=>$study_id])->first();
        return $study;
    }
}
