<?php

namespace App\Http\Controllers\V1\Chat;

use App\Events\SentMessageEvent;
use App\Http\Controllers\Controller;
use App\Models\Chat\Chat;
use App\Models\ChatRoom;
use App\Models\User;
use App\Models\UserChatRoom;
use Illuminate\Http\Request;

class ChatRoomController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'recipient' => 'required|exists:users,id'
        ]);


        $existInRoom = ChatRoom::where('user_id', auth()->user()->id)
            ->whereHas('users', function ($query) use ($request) {
                $query->where('user_id', $request->recipient);
            })
            ->first();


        if (!$existInRoom) {
            $recipient = User::find($request->recipient);

            $chatRoom = ChatRoom::create([
                'name' => $recipient->name
            ]);

            $chatRoom->users()->sync([$recipient->id, auth()->user()->id]);
            $chat = Chat::create([
                'chat_room_id' => $chatRoom->id,
                'user_id' => auth()->user()->id,
                'message' => $request->message
            ]);

            broadcast(new SentMessageEvent($chat));

            return redirect('/admin/chats/' . $chatRoom->uuid);
        } else {
            $chat = Chat::create([
                'chat_room_id' => $existInRoom->id,
                'user_id' => auth()->user()->id,
                'message' => $request->message
            ]);
            broadcast(new SentMessageEvent($chat));

            return redirect('/admin/chats/' . $existInRoom->uuid);
        }


    }
}
