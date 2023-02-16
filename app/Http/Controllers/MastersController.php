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

        try {
            $findedByData = Master::where([["id", "!=", $data['id']], "first_name" => $data['first_name'], "last_name" => $data['last_name']])->first();
            if ($findedByData)
                return back()->withInput(\Illuminate\Support\Facades\Request::except(''))->withErrors([
                    'founded_id' => 'id'
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

            return redirect()->to('/admin/edit-master/' . $master->id);
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

    public function delete(Request $request){
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $data = json_decode($request->getContent(), true);
        if (!array_key_exists('id', $data)) return json_encode(["error" => true, "message" => 'Master wasn\'t find']);

        try {
            Master::where("id", $data['id'])->delete();
            return json_encode(["error" => false, "message" => 'Deleted success']);
        } catch (\Exception $e) {
            return json_encode(["error" => true, "message" => $e->getMessage()]);
        }
    }

    public function changeVisible(Request $request){
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $data = json_decode($request->getContent(), true);
        if (!array_key_exists('id', $data)) return json_encode(["error" => true, "message" => 'Master wasn\'t find']);

        try {
            $master = Master::where("id", $data["id"])->first();
            $master->hidden = !$master->hidden;
            $master->save();
            return json_encode(["error" => false, "message" => 'Success', 'hidden' => $master->hidden]);
        } catch (\Exception $e) {
            return json_encode(["error" => true, "message" => $e->getMessage()]);
        }
    }

    public function master(Request $request, $id)
    {
        $master = Master::where('id', "=", $id)->where('hidden', false)->first();
        if (!$master) return abort(404);
        $comments = MasterComment::where("master_id", $id)->where("author_id", "=", auth()->user()->id)->get();
        return $this->view('masters.index', ['master' => $master, 'comments'=>$comments]);
    }
}
