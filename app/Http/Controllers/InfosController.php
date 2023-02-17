<?php

namespace App\Http\Controllers;

use App\Models\Info;
use App\Models\InfoPost;
use App\Models\StudyTopic;
use Illuminate\Http\Request;

class InfosController extends Controller
{
    public function createInfo()
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        return $this->view('infos.info-edit');
    }

    public function editInfo(Request $request, $id)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $info = Info::where('id', '=', $id)->first();

        if (!$info) return abort(404);

        return $this->view('infos.info-edit', [
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
            $findedByData = Info::where(["title_ru" => $data['title_ru'], ['id', '!=', $data['id']]])->first();
            if (!isset($findedByData)) {
                $findedByData = Info::where(["title_ua" => $data['title_ua'], ['id', '!=', $data['id']]])->first();
            }
            if ($findedByData && $findedByData['id'] != $data['id'])
                return back()->withInput(\Illuminate\Support\Facades\Request::except(''))->withErrors([
                    'error' => 'Розділ корисної інформації з такими даними уже існує: <a href="' . url("/admin/edit-info/" . $findedByData->id) . '">' . $data['title_ua'] . '</a>'
                ]);

            if ($findedByData && $findedByData['id'] == $data['id'] && $data['title_ua'] == $findedByData['title_ua'] && $data['title_ru'] == $findedByData['title_ru'])
                return back()->withInput(\Illuminate\Support\Facades\Request::except(''));

            $topic = Info::firstOrNew(['id' => $data['id']]);
            $topic->title_ua = $data['title_ua'];
            $topic->title_ru = $data['title_ru'];
            $topic->save();

            return redirect()->to('/admin/edit-info/' . $topic->id)->with('success', 'Розділ збережено успішно!');
        } catch (\Exception $e) {
            file_put_contents("log.txt", $e->getMessage());
            return back()->withInput(\Illuminate\Support\Facades\Request::except(''))->withErrors([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function delete(Request $request)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $data = json_decode($request->getContent(), true);
        if (!array_key_exists('id', $data)) return json_encode(["error" => true, "message" => 'Розділ корисної інформації не знайдено!']);

        try {
            Info::where("id", $data['id'])->delete();
            return json_encode(["error" => false, "message" => 'Розділ корисної інформації виддалено успішно!']);
        } catch (\Exception $e) {
            return json_encode(["error" => true, "message" => $e->getMessage()]);
        }
    }

    public function changeVisible(Request $request)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $data = json_decode($request->getContent(), true);

        if (!array_key_exists('id', $data)) return json_encode(["error" => true, "message" => 'Розділ корисної інформації не знайдено!']);

        try {
            $info = Info::where("id", $data["id"])->first();
            $info->hidden = !$info->hidden;
            $info->save();

            $message = "Розділ успішно приховано";
            if(!$info->hidden)$message = "Розділ успішно відновлено";

            return json_encode(["error" => false, "message" => $message, 'hidden' => $info->hidden]);
        } catch (\Exception $e) {
            return json_encode(["error" => true, "message" => $e->getMessage()]);
        }
    }


    public function createPost()
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $infos = Info::all();
        return $this->view('infos.post-edit', ['infos' => $infos]);
    }

    public function editPost(Request $request, $id)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $infos = Info::all();
        $post = InfoPost::where("id", "=", $id)->first();
        return $this->view('infos.post-edit', ['infos' => $infos,
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

            return redirect()->to('/admin/edit-info-post/' . $post->id)->with('success', 'Пост корисної інформації збережено успішно!');
        } catch (\Exception $e) {
            file_put_contents("log.txt", $e->getMessage());
            return back()->withInput(\Illuminate\Support\Facades\Request::except(''))->withErrors([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getPosts()
    {
        if (!is_numeric($_GET['start']) || !is_numeric($_GET['count'])) return json_encode(["error" => false, "events" => []]);

        if (!array_key_exists('topic', $_GET) || !is_numeric($_GET['topic'])) abort(404);

        $start = intval($_GET['start']);
        $count = intval($_GET['count']);
        $search = $_GET['search'] ?? "";

        return json_encode(["error" => false, "posts" => InfoPost::where("info_id", $_GET['topic'])
            ->where('hidden', false)
            ->where("title", 'like', '%' . $search . '%')
            ->skip($start)
            ->take($count)
            ->get()]);

    }

    public function deletePost(Request $request)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $data = json_decode($request->getContent(), true);
        if (!array_key_exists('id', $data)) return json_encode(["error" => true, "message" => 'Пост корисної інформації не знайдено!']);

        try {
            InfoPost::where("id", $data['id'])->delete();
            return json_encode(["error" => false, "message" => 'Пост корисної інформації видалено успішно!']);
        } catch (\Exception $e) {
            return json_encode(["error" => true, "message" => $e->getMessage()]);
        }
    }

    public function changeVisiblePost(Request $request)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $data = json_decode($request->getContent(), true);
        if (!array_key_exists('id', $data)) return json_encode(["error" => true, "message" => 'Пост корисної інформації не знайдено!']);

        try {
            $model = InfoPost::where("id", $data["id"])->first();
            $model->hidden = !$model->hidden;
            $model->save();

            $message = "Пост успішно приховано";
            if(!$model->hidden)$message = "Пост успішно відновлено";

            return json_encode(["error" => false, "message" => $message, 'hidden' => $model->hidden]);
        } catch (\Exception $e) {
            return json_encode(["error" => true, "message" => $e->getMessage()]);
        }
    }

    public function infosPosts(Request $request, $id)
    {
        $info = Info::where('id', $id)->where("hidden", false)->first();
        if (!$info) return abort(404);

        $posts_count = InfoPost::where("info_id", $id)->where('hidden', false)->count();
        return $this->view("infos.index", ['count' => $posts_count, 'topic_id' => $id]);
    }
}
