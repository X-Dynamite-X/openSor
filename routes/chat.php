<?php

use App\Http\Controllers\ConversationController;
use Illuminate\Support\Facades\Route;

 public function index(Request $request)
    {
        $userId = Auth::id();
        if($request->ajax()){
            if($request->has('search')){
                $searchTerm = $request->search;
                $users = User::whereAny(["name", "email"], 'LIKE', "%$searchTerm%")
                    ->where('id', '!=', $userId) // استبعاد المستخدم الحالي
                    ->limit(15)
                    ->get(['id', 'name', "email"]);
            }
             return response()->json([
                'new_conversations_html' => view('chat.partials.users', compact('users'))->render(),
                'message' => "Conversations fetched successfully."
            ]);

        }

        $conversations = Conversation::whereAny(["user_one_id","user_two_id"], 'LIKE', "%$userId%")
            ->orderBy('last_message_at', 'desc')
            ->with(['user1', 'user2', 'messages' => function($query) {
                $query->latest();
            }])
            ->withCount(['messages as unread_count' => function($query) use ($userId) {
                $query->where('is_read', false)
                      ->where('sender_id', '!=', $userId);
            }])
            ->get()
            ->map(function($conversation) use ($userId) {
                $conversation->other_user = $conversation->user_one_id === $userId
                    ? $conversation->user2
                    : $conversation->user1;
                $conversation->last_message = $conversation->messages->first();
                return $conversation;
            });

        return view('chat.index', compact('conversations'));
    }
