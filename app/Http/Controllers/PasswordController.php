<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordController extends Controller
{

    public function showForgetPasswordForm()
    {
        if (auth()->check()) return abort(404);
        return $this->view('auth.forget-password');
    }


    public function submitForgetPasswordForm(Request $request)
    {
        if (auth()->check()) return abort(404);
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $saved_tokens = DB::table('password_resets')->where('email', '=', $request->email);

        if ($saved_tokens->count() > 0) {
            $token = $saved_tokens->first()->token;
        } else {
            $token = Str::random(64);

            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);
        }

        Mail::send('email.forget-password', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return redirect()->to('/')->with('message', 'We have e-mailed your password reset link!');
    }

    public function showResetPasswordForm($token)
    {
        if (auth()->check()) return abort(404);
        return $this->view('auth.forget-password-link', ['token' => $token]);
    }


    public function submitResetPasswordForm(Request $request)
    {
        if (auth()->check()) return abort(404);
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_resets')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])
            ->first();

        if (!$updatePassword) {
            return back()->withInput()->with('error', 'Invalid token!');
        }

        $user = User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email' => $request->email])->delete();

        return redirect('/login')->with('message', 'Your password has been changed!');
    }

}
