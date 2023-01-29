<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController
{
    public function save(Request $request)
    {
        $file = $request->file("file");
        $filename = time() ."_". $file->getClientOriginalName();
        Storage::putFileAs('public/'.$request->input('type').'s/', $file, $filename);
        return json_encode(["filename" => $filename]);
    }
}
