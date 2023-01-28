<?php

namespace App\Http\Controllers;

use App\Models\Acivity;
use App\Models\Master;
use Illuminate\Http\Request;

class MastersController
{
    public function create()
    {
        if (!auth()->user()->admin) return redirect()->to('/');
        return view('masters.edit');
    }

    public function save(Request $request)
    {
        if (!auth()->user()->admin) return redirect()->to('/');

        $data = $request->input();

        if(!array_key_exists('id', $data)) {
            $data['id'] = '-1';
        }

        try {
            $findedByData = Master::where(["first_name" => $data['first_name'], "last_name" => $data['last_name']])->first();
            if ($findedByData && $findedByData['id'] != $data['id'])
                return json_encode(["error" => true, "founded_id" => $findedByData['id']]);

            if ($findedByData && $findedByData['id'] == $data['id'] && $data['img_src'] == $findedByData['img_src'] && $data['description'] == $findedByData['description'] && $data['first_name'] == $findedByData['first_name'] && $data['last_name'] == $findedByData['last_name'])
                return json_encode(["error" => false]);


            $master = Master::firstOrNew(['id' => $data['id']]);
            $master->img_src = $data['img_src'];
            $master->description = $data['description'];
            $master->first_name = $data['first_name'];
            $master->last_name = $data['last_name'];
            $master->save();

            return redirect()->to('/');
        } catch (\Exception $e) {
            file_put_contents("log.txt", $e->getMessage());
            return redirect()->to('/');
        }
    }

    public function masters(){
        $masters = Master::all();
        var_dump($masters);
        die;
    }

    public function master(Request $request, $id){
        $master = Master::where('id', "=", $id)->first();

        if(!$master) {
            var_dump("error");
            die;
        }
        return view('masters.index', ['master'=>$master]);
    }
}
