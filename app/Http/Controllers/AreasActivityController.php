<?php

namespace App\Http\Controllers;

use App\Models\Acivity;
use App\Models\Master;
use Illuminate\Http\Request;

class AreasActivityController extends Controller
{
    public function create()
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        return $this->view('areas-activities.edit');
    }

    public function edit(Request $request, $id)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $area_activity = Acivity::where('id', '=', $id)->first();

        if(!$area_activity) return abort(404);

        return $this->view('areas-activities.edit', [
            'title_ua'=>$area_activity->title_ua,
            'title_ru'=>$area_activity->title_ru,
            'id'=>$area_activity->id,
            'body'=>$area_activity->body,
            'img_src'=>$area_activity->img_src,
            'type'=>$area_activity->type
        ]);
    }

    public function save(Request $request)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);

        $data = $request->input();

        if(!array_key_exists('id', $data)) {
            $data['id'] = '-1';
        }

        try {
            $findedByData = Acivity::where(["title_ru" => $data['title_ru'], "title_ua" => $data['title_ua'], ["id", "!=", $data['id']]])->first();
            if ($findedByData)
                return back()->withInput(\Illuminate\Support\Facades\Request::except(''))->withErrors([
                    'founded_id' => 'id'
                ]);

            $findedByData = Acivity::where(["title_ru" => $data['title_ru'], "title_ua" => $data['title_ua']])->first();
            if ($findedByData && $findedByData['id'] == $data['id']&& $data['type'] == $findedByData['type'] && $data['img_src'] == $findedByData['img_src'] && $data['body'] == $findedByData['body'] && $data['title_ua'] == $findedByData['title_ua'] && $data['title_ru'] == $findedByData['title_ru'])
                return back()->withInput(\Illuminate\Support\Facades\Request::except(''));


            $acivity = Acivity::firstOrNew(['id' => $data['id']]);
            $acivity->img_src = $data['img_src'];
            $acivity->body = $data['body'];
            $acivity->type = $data['type'];
            $acivity->title_ua = $data['title_ua'];
            $acivity->title_ru = $data['title_ru'];
            $acivity->save();

            return redirect()->to('/admin/edit-activity/' . $acivity->id);
        } catch (\Exception $e) {
            file_put_contents("log.txt", $e->getMessage());
            return back()->withInput(\Illuminate\Support\Facades\Request::except(''))->withErrors([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function delete(Request $request){
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $data = json_decode($request->getContent(), true);
        if (!array_key_exists('id', $data)) return json_encode(["error" => true, "message" => 'Acivity wasn\'t find']);

        try {
            Acivity::where("id", $data['id'])->delete();
            return json_encode(["error" => false, "message" => 'Deleted success']);
        } catch (\Exception $e) {
            return json_encode(["error" => true, "message" => $e->getMessage()]);
        }
    }

    public function changeVisible(Request $request){
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $data = json_decode($request->getContent(), true);
        if (!array_key_exists('id', $data)) return json_encode(["error" => true, "message" => 'Acivity wasn\'t find']);

        try {
            return json_encode(["error" => false, "message" => 'Success']);
        } catch (\Exception $e) {
            return json_encode(["error" => true, "message" => $e->getMessage()]);
        }
    }

    public function titles(){
        $activities = Acivity::all(['id', 'title_ua', 'title_ru']);
        var_dump($activities);
        die;
    }

    public function topic(Request $request, $id){
        $activity = Acivity::where('id', "=", $id)->first();
        if(!$activity) return abort(404);
        return $this->view('areas-activities.index', ['activity'=>$activity]);
    }
}
