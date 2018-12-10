<?php

namespace App\Http\Controllers;

use App\User;

class ProfileController extends Controller
{
    public function show($id)
    {
        $user = User::where('id', $id)->firstOrFail();

        $friends = $user->friends();

        $friends_total = $friends->count();

        if ($friends_total > 6) {
            $friends = $friends->random(7)->shuffle();
        }
        
        $friendship = (auth()->check() ? auth()->user()->checkFriendship($user) : 'unauthenticated');

        return response()->json(compact('user', 'friends', 'friends_total', 'friendship'));
    }

    public function update()
    {
        $data = request()->validate([
            'avatar' => 'mimes:jpeg,jpg,bmp,png|max:10240',
            'firstname' => 'required|max:40',
            'lastname' => 'required|max:40',
            'location' => 'required|max:20',
        ]);

        $data['username'] = $data['lastname'].$data['firstname'];

        if (request()->hasFile('avatar')) {
            $path = request()->file('avatar')->store('public');
            $avatarName = explode("/", $path);
            $data['avatar'] = $avatarName[1];
        }

        auth()->user()->update($data);

        $user = auth()->user();

        $flash = "你的个人信息已经修改";

        return response()->json(compact('user', 'flash'));
    }

    public function statuses(User $user)
    {
        $cursor = (request()->has('cursor') ? ['id' => request('cursor')] : []);

        $statuses = $user->statuses()->topLevel()
            ->cursorPaginate(5, $cursor, 'desc');

        return response()->json($statuses);
    }
}
