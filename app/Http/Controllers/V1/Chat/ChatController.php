<?php

namespace App\Http\Controllers\V1\Chat;

use App\Events\SentMessageEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\StoreChatRequest;
use App\Http\Requests\Chat\UpdateChatRequest;
use App\Models\Chat\Chat;
use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{


    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('access chat'), Response::HTTP_FORBIDDEN, '401 Unauthorized');


        $chats = ChatRoom::all();


        return inertia('Chat/Index', [
            'rooms' => ChatRoom::all(),
            'room' => $request->room,
            'users' => User::select(['id', 'name', 'email'])
                ->where('id', '!=', auth()->user()->id)
                ->get(),
            'request' => $request->all(),
        ]);

    }


    public function edit($id)
    {
        abort_if(!auth()->user()->can('edit chat'), Response::HTTP_FORBIDDEN, '401 Unauthorized');

        $chat = Chat::find($id);

        return inertia('Chat/Form');
    }

    public function show(Request $request, $id)
    {
        abort_if(!auth()->user()->can('view chat'), Response::HTTP_FORBIDDEN, '401 Unauthorized');


        $room = ChatRoom::where('uuid', $id)->first();

        return inertia('Chat/Index', [
            'chats' => $room->chats ?? [],
            'rooms' => ChatRoom::whereHas('users', function ($query) {
                $query->where('user_id', auth()->user()->id);
            })->latest()->get(),
            'room' => $room,
            'users' => User::select(['id', 'name', 'email'])
                ->where('id', '!=', auth()->user()->id)
                ->get(),
            'request' => $request->all(),
        ]);
    }

    public function store(StoreChatRequest $request)
    {

        $chat_arr = $request->validated();

        $chat_arr['chat_room_id'] = ChatRoom::where('uuid', $chat_arr['room'])->first()->id;
        $chat = Chat::create($chat_arr);


        broadcast(new SentMessageEvent($chat));

        return $chat;
    }


    public function update(UpdateChatRequest $request, $id): \Illuminate\Http\RedirectResponse
    {

        $chat_arr = $request->validated();

        $chat = Chat::find($id);
        $chat->update($chat_arr);

        return redirect()->back();
    }

    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        abort_if(!auth()->user()->can('delete chat'), Response::HTTP_FORBIDDEN, '401 Unauthorized');

        $chat = Chat::find($id);
        $chat->delete();

        return redirect()->back();
    }
}
