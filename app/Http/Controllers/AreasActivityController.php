<?php

namespace App\Http\Controllers;

use App\Models\Acivity;
use Illuminate\Http\Request;

class AreasActivityController
{
    public function create()
    {
        if (!auth()->user()->admin) return redirect()->to('/');
        return view('areas-activities.edit');
    }

    public function save(Request $request)
    {
        if (!auth()->user()->admin) return redirect()->to('/');

        $data = $request->input();

        if(!array_key_exists('id', $data)) {
            $data['id'] = '-1';
        }

        try {
            $findedByData = Acivity::where(["title_ru" => $data['title_ru'], "title_ua" => $data['title_ua']])->first();
            if ($findedByData && $findedByData['id'] != $data['id'])
                return json_encode(["error" => true, "founded_id" => $findedByData['id']]);

            if ($findedByData && $findedByData['id'] == $data['id'] && $data['img_src'] == $findedByData['img_src'] && $data['body'] == $findedByData['body'] && $data['title_ua'] == $findedByData['title_ua'] && $data['title_ru'] == $findedByData['title_ru'])
                return json_encode(["error" => false]);


            $acivity = Acivity::firstOrNew(['id' => $data['id']]);
            $acivity->img_src = $data['img_src'];
            $acivity->body = $data['body'];
            $acivity->title_ua = $data['title_ua'];
            $acivity->title_ru = $data['title_ru'];
            $acivity->save();

            return redirect()->to('/');
        } catch (\Exception $e) {
            file_put_contents("log.txt", $e->getMessage());
            return redirect()->to('/');
        }
    }

    public function titles(){
        $activities = Acivity::all(['id', 'title_ua', 'title_ru']);
        var_dump($activities);
        die;
    }

    public function topic(Request $request, $id){
        $activity = Acivity::where('id', "=", $id)->first();
        if(!$activity) {
            var_dump("error");
            die;
        }
        return view('areas-activities.index', ['activity'=>$activity]);
    }
}
