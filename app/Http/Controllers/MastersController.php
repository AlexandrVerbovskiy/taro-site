<?php

namespace App\Http\Controllers;

use App\Models\Master;
use App\Models\MasterComment;
use Illuminate\Http\Request;

class MastersController extends Controller
{
    public function create()
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        return $this->view('masters.edit');
    }

    public function edit(Request $request, $id)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $master = Master::where('id', '=', $id)->first();

        if (!$master) return abort(404);

        return $this->view('masters.edit', [
            'first_name' => $master->first_name,
            'last_name' => $master->last_name,
            'id' => $master->id,
            'description' => $master->description,
            'img_src' => $master->img_src,
        ]);
    }

    public function save(Request $request)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);

        $data = $request->input();

        if (!array_key_exists('id', $data)) {
            $data['id'] = '-1';
        }

        if (!array_key_exists('first_name', $data) || !array_key_exists('last_name', $data)
            || !array_key_exists('description', $data) || !array_key_exists('img_src', $data)
            || !$data['first_name'] || strlen($data['first_name']) < 1
            || !$data['last_name'] || strlen($data['last_name']) < 1
            || !$data['description'] || strlen($data['description']) < 1
            || !$data['img_src'] || strlen($data['img_src']) < 1
        ) return back()->withInput(\Illuminate\Support\Facades\Request::except(''))->withErrors("Жодне поле не може бути порожнім!");

        try {
            $findedByData = Master::where([["id", "!=", $data['id']], "first_name" => $data['first_name'], "last_name" => $data['last_name']])->first();
            if ($findedByData)
                return back()->withInput(\Illuminate\Support\Facades\Request::except(''))->withErrors([
                    'error' => 'Майстр з такими даними уже існує: <a href="' . url("/admin/edit-master/" . $findedByData->id) . '">' . $findedByData->last_name . ' ' . $findedByData->first_name . '</a>'
                ]);

            $findedByData = Master::where(["first_name" => $data['first_name'], "last_name" => $data['last_name']])->first();
            if ($findedByData && $findedByData['id'] == $data['id'] && $data['img_src'] == $findedByData['img_src'] && $data['description'] == $findedByData['description'] && $data['first_name'] == $findedByData['first_name'] && $data['last_name'] == $findedByData['last_name'])
                return back()->withInput(\Illuminate\Support\Facades\Request::except(''));


            $master = Master::firstOrNew(['id' => $data['id']]);
            $master->img_src = $data['img_src'];
            $master->description = $data['description'];
            $master->first_name = $data['first_name'];
            $master->last_name = $data['last_name'];
            $master->save();

            return redirect()->to('/admin/edit-master/' . $master->id)->with('success', 'Майстра збережено успішно!');
        } catch (\Exception $e) {
            file_put_contents("log.txt", $e->getMessage());
            return back()->withInput(\Illuminate\Support\Facades\Request::except(''))->withErrors([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function masters()
    {
        $masters = Master::where('hidden', false)->get();
        return $this->view('masters.all', ['masters' => $masters]);
    }

    public function delete(Request $request)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $data = json_decode($request->getContent(), true);
        if (!array_key_exists('id', $data)) return json_encode(["error" => true, "message" => 'Майстра не знайдено!']);

        try {
            Master::where("id", $data['id'])->delete();
            return json_encode(["error" => false, "message" => 'Майстра видалено успішно!']);
        } catch (\Exception $e) {
            return json_encode(["error" => true, "message" => $e->getMessage()]);
        }
    }

    public function changeVisible(Request $request)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $data = json_decode($request->getContent(), true);
        if (!array_key_exists('id', $data)) return json_encode(["error" => true, "message" => 'Майстра не знайдено!']);

        try {
            $master = Master::where("id", $data["id"])->first();
            $master->hidden = !$master->hidden;
            $master->save();

<<<<<<< HEAD
            $full_namme = $master->first_name." ".$master->last_name;

            $message = 'Майстер бльше не відображається у користувачів!';
            if(!$master->hidden) $message = 'Майстер знову відображається у користувачів!';
=======
            $full_namme = $master->first_name . " " . $master->last_name;

            $message = 'Майстер бльше не відображається у користувачів!';
            if (!$master->hidden) $message = 'Майстер знову відображається у користувачів!';
>>>>>>> fa4314e1fa79a775cf1e52aa163e445d19091781

            return json_encode(["error" => false, "message" => $message, 'hidden' => $master->hidden]);
        } catch (\Exception $e) {
            return json_encode(["error" => true, "message" => $e->getMessage()]);
        }
    }

    public function master(Request $request, $id)
    {
        $master = Master::where('id', "=", $id)->where('hidden', false)->first();
        if (!$master) return abort(404);
<<<<<<< HEAD
        $comments = MasterComment::where("master_id", $id)->where("author_id", "=", auth()->user()->id)->get();
=======
        if(auth()->user()) {
            $comments = MasterComment::where("master_id", $id)->where("author_id", "=", auth()->user()->id)->get();
        }else{
            $comments = [];
        }
>>>>>>> fa4314e1fa79a775cf1e52aa163e445d19091781
        return $this->view('masters.index', ['master' => $master, 'comments' => $comments]);
    }
}
