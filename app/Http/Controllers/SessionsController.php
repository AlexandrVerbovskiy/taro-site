<?php

namespace App\Http\Controllers;

use App\Models\User;

class SessionsController
{
    public function create()
    {
        if (auth()->check()) return redirect()->to('/');
        return view('auth.login');
    }

    public function store()
    {

        if (auth()->check()) return redirect()->to('/');
        if (auth()->attempt(request(['email', 'password'])) == false) {
            return back()->withErrors([
                'message' => 'The email or password is incorrect, please try again'
            ]);
        }

        return redirect()->to('/');
    }

    public function destroy()
    {
        if (!auth()->check()) return redirect()->to('/login');
        auth()->logout();

        return redirect()->to('/login');
    }
}
