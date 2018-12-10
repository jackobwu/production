<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\Invite;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function register()
    {
        $token = request()->get('token');

        if (!$invite = Invite::where('token', $token)->first()) {
            //if the invite doesn't exist do something more graceful than this
            return response()->json(['flash' => '邀请码不存在']);
        }

        $data = request()->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'firstname' => 'required|max:40',
            'lastname' => 'required|max:40',
        ]);

        $data['username'] = $data['lastname'].$data['firstname'];

        $user = User::create($data);
        $token = auth()->attempt(request()->only(['email', 'password']));
        $flash = '你的账号已经创建';

        $invite->delete();

        return response()->json(compact('user','token', 'flash'));
    }
}