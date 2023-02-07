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

        try {
            $findedByData = EventTopic::where(["title_ua" => $data['title_ua'], ['id', '!=', $data['id']]])->first();
            if (is_null($findedByData)) {
                $findedByData = EventTopic::where(["title_ru" => $data['title_ru'], ['id', '!=', $data['id']]])->first();
            }
            if ($findedByData && $findedByData['id'] != $data['id'])
                return back()->withInput(\Illuminate\Support\Facades\Request::except(''))->withErrors([
                    'founded_id' => 'id'
                ]);

            if ($findedByData && $findedByData['id'] == $data['id'] && $data['title_ua'] == $findedByData['title_ua'] && $data['title_ru'] == $findedByData['title_ru'])
                return back()->withInput(\Illuminate\Support\Facades\Request::except(''));

            $topic = EventTopic::firstOrNew(['id' => $data['id']]);
            $topic->title_ua = $data['title_ua'];
            $topic->title_ru = $data['title_ru'];
            $topic->save();

            return redirect()->to('/admin/edit-topic-event/' . $topic->id);
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
        if (!array_key_exists('id', $data)) return json_encode(["error" => true, "message" => 'Topic wasn\'t find']);

        try {
            EventTopic::where("id", $data['id'])->delete();
            return json_encode(["error" => false, "message" => 'Deleted success']);
        } catch (\Exception $e) {
            return json_encode(["error" => true, "message" => $e->getMessage()]);
        }
    }

    public function changeVisibleTopic(Request $request)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $data = json_decode($request->getContent(), true);
        if (!array_key_exists('id', $data)) return json_encode(["error" => true, "message" => 'Topic wasn\'t find']);

        try {
            return json_encode(["error" => false, "message" => 'Success']);
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

            return redirect()->to('/');
        } catch (\Exception $e) {
            file_put_contents("log.txt", $e->getMessage());
            return back()->withInput(\Illuminate\Support\Facades\Request::except(''))->withErrors([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function events(Request $request, $id)
    {
        $posts_count = Event::where("events_topic_id", $id)->count();
        return $this->view("events.index", ['count' => $posts_count]);
    }

}
