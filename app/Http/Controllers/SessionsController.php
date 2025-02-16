<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;

class SessionsController extends Controller
{
    public function create()
    {
        if (auth()->check()) return abort(404);
        return $this->view('auth.login');
    }

    public function store()
    {
        if (auth()->check()) return abort(404);
        if (auth()->attempt(request(['email', 'password'])) == false) {
            return back()->withInput(Request::except('password'))->withErrors([
                'message' => 'The email or password is incorrect, please try again'
            ])->with('login', true);
        }
        return redirect()->to('/');
    }

    public function destroy()
    {
        if (!auth()->check()) return redirect()->to('/');
        auth()->logout();

        return redirect()->to('/');
    }
}
