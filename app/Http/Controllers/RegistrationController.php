<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegistrationController extends Controller
{
    public function create()
    {
        if (auth()->check()) return redirect()->to('/');
        return view('auth.registration');
    }

    public function store()
    {
        if (auth()->check()) return redirect()->to('/');

        $this->validate(request(), [
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'first_name'=> 'required',
            'last_name'=> 'required',
            'phone'=> 'required',
            'telegram'=> 'required'
        ]);

        User::create(request(['first_name','phone','telegram','last_name', 'email', 'password']));

        return redirect()->to('/');
    }
}
