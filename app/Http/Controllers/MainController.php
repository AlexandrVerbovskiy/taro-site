<?php

namespace App\Http\Controllers;

use App\Models\Master;

class MainController extends Controller
{
    public function home()
    {
        return $this->view("welcome");
    }

    public function admin()
    {
        //if (!auth()->check() || !auth()->user()->admin) return abort(404);
        return view("admin.main");
    }

    public function masters()
    {
        //if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $masters = Master::all();
        return view("admin.masters", ['masters' => $masters]);
    }
}
