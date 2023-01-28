<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Request;

class UserController extends Controller
{
    public function editProfile()
    {
        if (!auth()->check()) return redirect()->to('/');
        $user = auth()->user();
        return view('users.edit-profile', [
            'id' => $user->id,
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'phone' => $user->phone,
            'telegram' => $user->telegram,
        ]);
    }

    public function saveProfile()
    {
        if (!auth()->check()) return redirect()->to('/');

        $this->validate(request(), [
            'email' => 'required|email',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'telegram' => 'required'
        ]);

        if (request()->input('id') != auth()->user()->id)
            return back()->withInput(Request::except(''))->withErrors([
                'message' => 'Permission denied!'
            ]);

        User::where('id', request()->input('id'))  // find your user by their email
        ->limit(1)  // optional - to ensure only one record is updated.
        ->update(array(
            'email' => request()->input('email'),
            'first_name' => request()->input('first_name'),
            'last_name' => request()->input('last_name'),
            'phone' => request()->input('phone'),
            'telegram' => request()->input('telegram'),
        ));

        return redirect()->to('/edit-profile');
    }
}
