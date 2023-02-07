<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegistrationController extends Controller
{
    public function create()
    {
        if (auth()->check()) return abort(404);
        return $this->view('auth.registration');
    }

    public function store()
    {
        if (auth()->check()) return abort(404);

        $this->validate(request(), [
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'first_name'=> 'required',
            'last_name'=> 'required',
            'phone'=> 'required',
            'social_type'=> 'required'
        ]);

        User::create(request(['first_name','phone','telegram','last_name', 'email','social_phone', 'social_type', 'password']));

        return redirect()->to('/');
    }
}
