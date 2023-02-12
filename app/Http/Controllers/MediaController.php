<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController
{
    public function save(Request $request)
    {
        try {
            $file = $request->file("file");
            if (is_null($file)) return json_encode(["filename" => 'null']);
            $filename = time() . "_" . $file->getClientOriginalName();
            Storage::putFileAs('public/' . $request->input('type') . 's/', $file, $filename);
            return json_encode(["filename" => $filename]);
        }catch(\Exception $e){
            return json_encode(["filename" => 'null']);
        }
    }
}
