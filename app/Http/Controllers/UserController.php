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
        return $this->view('users.edit-profile', [
            'id' => $user->id,
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'phone' => $user->phone,
            'social_phone' => $user->social_phone,
            'social_type' => $user->social_type,
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
            'social_type' => 'required'
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
            'social_type' => request()->input('social_type'),
            'social_phone' => request()->input('social_phone'),
        ));

        return redirect()->to('/edit-profile');
    }

    public function updateAdminStatus(\Illuminate\Http\Request $request)
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $data = json_decode($request->getContent(), true);

        if (!array_key_exists('id', $data)) $data['id'] = '-1';

        $id = $data['id'];
        $status = $data['status'];
        try {
            $user = User::where("id", "=", $id)->first();
            if (!$user) {
                return json_encode(["error" => true, "message" => "User wasn't find"]);
            }
            $user->admin = $status;
            $user->save();
            return json_encode(["error" => false, "user" => $user]);
        } catch (\Exception $e) {
            file_put_contents("log.txt", $e->getMessage());
            return json_encode(["error" => true, "message" => "Something went wrong"]);
        }
    }

    public function users()
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        //$users = User::all("id", "email", "admin")->first();
        //return $users;
        return view("admin.users", ['count' => User::all("id", "email", "admin")->count()]);
    }

    public function asyncUsers()
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);

        $start = intval($_GET['start']);
        $count = intval($_GET['count']);
        return json_encode(["error" => false, "users" => User::skip($start)->take($count)->get()]);
    }

    public function changeUsers()
    {
        if (!auth()->check() || !auth()->user()->admin) return abort(404);
        $id = intval($_GET['id']);

        if($id==auth()->user()->id||$id=="1"){
            return json_encode(["error" => true, "message" => "You can't change this user"]);
        }

        $user = User::where("id", "=", $id)->first();
        if (!$user) return json_encode(["error" => true, "message" => "User wasn't find"]);
        $user->admin = !$user->admin;
        $user->save();
        return json_encode(["error" => false, "status" => $user->admin]);
    }
}
