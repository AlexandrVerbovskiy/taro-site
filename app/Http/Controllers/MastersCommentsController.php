<?php

namespace App\Http\Controllers;

use App\Models\Master;
use App\Models\MasterComment;
use Illuminate\Http\Request;

class MastersCommentsController
{
    public function create(Request $request)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $data = json_decode($request->getContent(), true);
        if (!array_key_exists('master_id', $data)) return ["error" => true, "message" => "You can't leave a comment for a non-master"];
        if (!array_key_exists('body', $data) || strlen($data['body']) < 1) return ["error" => true, "message" => "You can't leave an empty comment for a master"];

        try {
            $comment = MasterComment::create([
                'master_id' => $data['master_id'],
                'body' => $data['body'],
                'author_id' => auth()->user()->id
            ]);

            return json_encode(["error" => false, "comment" => $comment]);
        } catch (\Exception $e) {
            file_put_contents("log.txt", $e->getMessage());
            return json_encode(["error" => true, "message" => "Something went wrong"]);
        }
    }

    public function getForMaster(Request $request)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $data = json_decode($request->getContent(), true);
        if (!array_key_exists('master_id', $data) || !array_key_exists('count', $data) || !array_key_exists('start', $data)) return abort(404);
        try {
            $comments = MasterComment::where("master_id", $data["master_id"])
                ->where("author_id", "<>", auth()->user()->id)
                ->skip($data['start'])
                ->take($data['count'])
                ->get();
            return json_encode(["error" => false, "comments" => $comments]);
        } catch (\Exception $e) {
            file_put_contents("log.txt", $e->getMessage());
            return json_encode(["error" => true, "message" => "Something went wrong"]);
        }
    }

    public function delete(Request $request)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $data = json_decode($request->getContent(), true);
        if (!array_key_exists('id', $data)) return abort(404);
        try {
            MasterComment::where("id", $data["id"])->delete();
            return json_encode(["error" => false]);
        }catch (\Exception $e) {
            file_put_contents("log.txt", $e->getMessage());
            return json_encode(["error" => true, "message" => "Something went wrong"]);
        }
    }
}
