<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventTopic;
use App\Models\Info;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function createTopic()
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        return $this->view('events.topic-edit');
    }

    public function editTopic(Request $request, $id)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $info = EventTopic::where('id', '=', $id)->first();

        if (!$info) return abort(404);

        return $this->view('events.topic-edit', [
            'title_ua' => $info->title_ua,
            'title_ru' => $info->title_ru,
            'id' => $info->id
        ]);
    }

    public function saveTopic(Request $request)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);

        $data = $request->input();

        if (!array_key_exists('id', $data)) {
            $data['id'] = '-1';
        }

        if (!array_key_exists('title_ua', $data) || !array_key_exists('title_ru', $data)
            || !$data['title_ua'] || strlen($data['title_ua']) < 1
            || !$data['title_ru'] || strlen($data['title_ru']) < 1
        ) return back()->withInput(\Illuminate\Support\Facades\Request::except(''))->withErrors("Жодне поле не може бути порожнім!");


        try {
            $findedByData = EventTopic::where([["title_ua","=", $data['title_ua']], ['id', '!=', $data['id']]])->first();
            if (is_null($findedByData)) {
                $findedByData = EventTopic::where([["title_ru", "=", $data['title_ru']], ['id', '!=', $data['id']]])->first();
            }


            if ($findedByData && $findedByData['id'] != $data['id'])
                return back()->withInput(\Illuminate\Support\Facades\Request::except(''))->withErrors([
                    'error' => 'Розділ подій з такими даними уже існує: <a href="' . url("/admin/edit-topic-event/" . $findedByData->id) . '">' . $data['title_ua'] . '</a>'
                ]);

            if ($findedByData && $findedByData['id'] == $data['id'] && $data['title_ua'] == $findedByData['title_ua'] && $data['title_ru'] == $findedByData['title_ru'])
                return back()->withInput(\Illuminate\Support\Facades\Request::except(''));

            $topic = EventTopic::firstOrNew(['id' => $data['id']]);
            $topic->title_ua = $data['title_ua'];
            $topic->title_ru = $data['title_ru'];
            $topic->save();

            return redirect()->to('/admin/edit-topic-event/' . $topic->id)->with('success', 'Розділ збережено успішно!');
        } catch (\Exception $e) {
            file_put_contents("log.txt", $e->getMessage());
            return back()->withInput(\Illuminate\Support\Facades\Request::except(''))->withErrors([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function deleteTopic(Request $request)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $data = json_decode($request->getContent(), true);
        if (!array_key_exists('id', $data)) return json_encode(["error" => true, "message" => 'Розділ не було знайдено!']);

        try {
            EventTopic::where("id", $data['id'])->delete();
            return json_encode(["error" => false, "message" => 'Розділ успішно видалено']);
        } catch (\Exception $e) {
            return json_encode(["error" => true, "message" => $e->getMessage()]);
        }
    }

    public function changeVisibleTopic(Request $request)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $data = json_decode($request->getContent(), true);
        if (!array_key_exists('id', $data)) return json_encode(["error" => true, "message" => 'Розділ не було знайдено!']);

        try {
            $model = EventTopic::where("id", $data["id"])->first();
            $model->hidden = !$model->hidden;
            $model->save();

            $message = "Розділ успішно приховано";
            if (!$model->hidden) $message = "Розділ успішно відновлено";

            return json_encode(["error" => false, "message" => $message, 'hidden' => $model->hidden]);
        } catch (\Exception $e) {
            return json_encode(["error" => true, "message" => $e->getMessage()]);
        }
    }


    public function createPost()
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $topic = EventTopic::all();
        return $this->view('events.event-edit', ['topics' => $topic]);
    }

    public function editPost(Request $request, $id)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $topic = EventTopic::all();
        $post = Event::where("id", "=", $id)->first();
        return $this->view('events.event-edit', ['topics' => $topic,
            'id' => $post->id,
            'events_topic_id' => $post->events_topic_id,
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

        if (!array_key_exists('title', $data) || !array_key_exists('media_type', $data)
            || !array_key_exists('url', $data) || !array_key_exists('body', $data)
            || !$data['title'] || strlen($data['title']) < 1
            || !$data['media_type'] || strlen($data['media_type']) < 1
            || !$data['url'] || strlen($data['url']) < 1
            || !$data['body'] || strlen($data['body']) < 1
        ) return back()->withInput(\Illuminate\Support\Facades\Request::except(''))->withErrors("Жодне поле не може бути порожнім!");


        try {
            $findedByData = Event::where(["id" => $data['id']])->first();

            if ($findedByData && $findedByData['body'] == $data['body'] && $findedByData['url'] == $data['url'] && $findedByData['id'] == $data['id'] && $data['media_type'] == $findedByData['title'] && $data['title'] == $findedByData['title'] && $data['infoevents_topic_id_id'] == $findedByData['events_topic_id'])
                return back()->withInput(\Illuminate\Support\Facades\Request::except(''));

            $post = Event::firstOrNew(['id' => $data['id']]);
            $post->title = $data['title'];
            $post->events_topic_id = $data['events_topic_id'];
            $post->media_type = $data['media_type'];
            $post->url = $data['url'];
            $post->body = $data['body'];
            $post->save();

            return redirect()->to('/admin/edit-event/' . $post->id)->with('success', 'Подію збережено успішно!');
        } catch (\Exception $e) {
            file_put_contents("log.txt", $e->getMessage());
            return back()->withInput(\Illuminate\Support\Facades\Request::except(''))->withErrors([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function events(Request $request, $id)
    {
        $event = EventTopic::where('id', $id)->where("hidden", false)->first();
        if (!$event) return abort(404);

        $posts_count = Event::where("events_topic_id", $id)->where('hidden', false)->count();
        return $this->view("events.index", ['count' => $posts_count, 'topic_id' => $id, 'topic_title_ru' => $event->title_ru, 'topic_title_ua' => $event->title_ua]);
    }

    public function getPosts()
    {
        if (!is_numeric($_GET['start']) || !is_numeric($_GET['count'])) return json_encode(["error" => false, "events" => []]);

        $start = intval($_GET['start']);
        $count = intval($_GET['count']);
        $search = $_GET['search'] ?? "";

        if (array_key_exists('topic', $_GET) && is_numeric($_GET['topic']))
            return json_encode(["error" => false, "events" => Event::where("events_topic_id", $_GET['topic'])
                ->where('hidden', false)
                ->where("title", 'like', '%' . $search . '%')
                ->skip($start)
                ->take($count)
                ->get()]);
        abort(404);
    }

    public function deletePost(Request $request)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $data = json_decode($request->getContent(), true);
        if (!array_key_exists('id', $data)) return json_encode(["error" => true, "message" => 'Подію не знайдено!']);

        try {
            Event::where("id", $data['id'])->delete();
            return json_encode(["error" => false, "message" => 'Подію успішно видалено']);
        } catch (\Exception $e) {
            return json_encode(["error" => true, "message" => $e->getMessage()]);
        }
    }

    public function changeVisiblePost(Request $request)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $data = json_decode($request->getContent(), true);
        if (!array_key_exists('id', $data)) return json_encode(["error" => true, "message" => 'Подію не знайдено!']);

        try {
            $model = Event::where("id", $data["id"])->first();
            $model->hidden = !$model->hidden;
            $model->save();

            $message = "Подію успішно приховано";
            if (!$model->hidden) $message = "Подію успішно відновлено";

            return json_encode(["error" => false, "message" => $message, 'hidden' => $model->hidden]);
        } catch (\Exception $e) {
            return json_encode(["error" => true, "message" => $e->getMessage()]);
        }
    }

}
