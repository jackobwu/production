<?php

namespace App\Http\Controllers;

use App\User;

class FriendshipController extends Controller
{
    public function index()
    {
        return response()->json([
            'friends' => auth()->user()->friends(),
            'requests' => auth()->user()->friendRequestsReceived(),
            'sents' => auth()->user()->friendRequestsSent(),
        ]);
    }

    public function store()
    {
        $user = User::findOrFail(request('id'));

        if (auth()->user()->checkFriendship($user) !== 'not_friends') {
            return response()->json(['flash' => '无效操作.'], 422);
        }
        
        auth()->user()->addFriend($user);
        return response()->json(['flash' => '好友请求已经发出.']);
    }

    public function update(User $user)
    {
        if (auth()->user()->checkFriendship($user) !== 'pending') {
            return response()->json(['flash' => '无效操作.'], 422);
        }

        auth()->user()->acceptFriend($user);
        return response()->json(['flash' => "{$user->username}现在是你的好友了."]);
    }

    public function destroy(User $user)
    {
        auth()->user()->deleteFriend($user);

        $message = [
            'cancel' => '取消好友请求.',
            'decline' => '拒绝好友请求.',
            'unfriend' => "你已经解除和{$user->firstname}的好友关系.",
        ];

        return response()->json(['flash' => $message[request('action')]]);
    }
}
