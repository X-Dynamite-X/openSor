<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Events\NewMessageEvent;
use App\Http\Requests\TextMessageRequest;
use App\Models\Conversation;

class MessageController extends Controller
{
    //
    public function store(TextMessageRequest $request)
    {

        $message = Message::create(
            [
                'sender_id' => Auth::id(),
                'conversation_id' => $request->input('conversation_id'),
                'text' => $request->input('text'),
                "is_read"=>false,
                'created_at' => $request->input('created_at'),
                "updated_at" => null,
            ]
        );
        Conversation::where('id', $request->input('conversation_id'))->update([
            'last_message' => $request->input('text'),
            'last_message_at' => now(),
        ]);

        event(new NewMessageEvent($message));
        $new_message_html = view("chat.components.sendNewMessage", compact('message'))->render();
        return response()->json([
            'newMessage' => $message,
            'new_message_html' => $new_message_html,
            'message' => 'Message Create Successfully',
        ]);
    }
    public function update() {}
    public function delete() {}
}
