<?php

namespace App\Http\Controllers;

use App\Models\Info;
use App\Models\InfoPost;
use App\Models\StudyTopic;
use Illuminate\Http\Request;

class InfosController
{
    public function createInfo()
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        return view('infos.info-edit');
    }

    public function editInfo(Request $request, $id)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $info = Info::where('id', '=', $id)->first();

        if (!$info) return abort(404);

        return view('infos.info-edit', [
            'title_ua' => $info->title_ua,
            'title_ru' => $info->title_ru,
            'id' => $info->id
        ]);
    }

    public function saveInfo(Request $request)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);

        $data = $request->input();

        if (!array_key_exists('id', $data)) {
            $data['id'] = '-1';
        }

        try {
            $findedByData = Info::where(["title_ru" => $data['title_ru'], ['id' ,'!=',$data['id']]])->first();
            if (!isset($findedByData)) {
                $findedByData = Info::where(["title_ua" => $data['title_ua'], ['id' ,'!=',$data['id']]])->first();
            }
            if ($findedByData && $findedByData['id'] != $data['id'])
                return back()->withInput(\Illuminate\Support\Facades\Request::except(''))->withErrors([
                    'founded_id' => 'id'
                ]);

            if ($findedByData && $findedByData['id'] == $data['id'] && $data['title_ua'] == $findedByData['title_ua'] && $data['title_ru'] == $findedByData['title_ru'])
                return back()->withInput(\Illuminate\Support\Facades\Request::except(''));

            $topic = Info::firstOrNew(['id' => $data['id']]);
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

    public function createPost()
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $infos = Info::all();
        return view('infos.post-edit', ['infos' => $infos]);
    }

    public function editPost(Request $request, $id)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $infos = Info::all();
        $post = InfoPost::where("id", "=", $id)->first();
        return view('infos.post-edit', ['infos' => $infos,
            'id' => $post->id,
            'info_id' => $post->info_id,
            'title' => $post->title,
            'media_type' => $post->media_type,
            'url' => $post->url,
            'body' => $post->body
        ]);
    }

    public function savePost(Request $request)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);

        $data = $request->input();

        if (!array_key_exists('id', $data)) {
            $data['id'] = '-1';
        }

        try {
            $findedByData = InfoPost::where(["id" => $data['id']])->first();

            if ($findedByData && $findedByData['body'] == $data['body'] && $findedByData['url'] == $data['url'] && $findedByData['id'] == $data['id'] && $data['media_type'] == $findedByData['title'] && $data['title'] == $findedByData['title'] && $data['info_id'] == $findedByData['info_id'])
                return back()->withInput(\Illuminate\Support\Facades\Request::except(''));

            $post = InfoPost::firstOrNew(['id' => $data['id']]);
            $post->title = $data['title'];
            $post->info_id = $data['info_id'];
            $post->media_type = $data['media_type'];
            $post->url = $data['url'];
            $post->body = $data['body'];
            $post->save();

            return redirect()->to('/');
        } catch (\Exception $e) {
            file_put_contents("log.txt", $e->getMessage());
            return back()->withInput(\Illuminate\Support\Facades\Request::except(''))->withErrors([
                'message' => $e->getMessage()
            ]);
        }
    }
}
