<?php

namespace App\Http\Controllers;

use App\Status;

class ReplyController extends Controller
{
    public function index(Status $status)
    {
        return response()->json($status->replies);
    }

    public function store(Status $status)
    {
        $data = request()->validate(['body' => 'max:300'], [], ['body' => 'reply']);

        
        if (request()->hasFile('image')) {
            $path = request()->file('image')->store('public');
            $imageName = explode("/", $path);
            $data['image'] = $imageName[1];
        }  
        

        $data['user_id'] = auth()->id();    

        if (!$status->of_friend && $status->user->id !== auth()->id()) {
            return response()->json([
                'flash' => "Add {$status->user->firstname} as a friend to reply to their statuses."
            ], 422);
        }

        if ($data['body'] !== null || $data['image'] !==null) {
            $reply = $status->replies()->create($data)->load('user');

            $flash = '回复发表.';

            return response()->json(compact('reply', 'flash'));
        }

        
    }
}
