<?php

namespace App\Http\Controllers;

use App\Models\User;
 use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Events\IsReadeMssages;
use App\Events\NewConversationEvent;
use App\Http\Requests\ConversationRequest;
use App\Http\Resources\ConversationResource;
class ConversationController extends Controller
{
    //
    public function index(Request $request)
    {
        $userId = Auth::id();

        if ($request->ajax()) {
            $users = collect(); // مجموعة فارغة إذا لم يكن هناك بحث
            if ($request->has('search')) {
                $searchTerm = $request->search;
                $users = User::whereAny(["name", "email"], 'LIKE', "%$searchTerm%")
                    ->where('id', '!=', $userId) // استبعاد المستخدم الحالي
                    ->limit(15)
                    ->get(['id', 'name', "email"]);
            }
            return response()->json([
                'conversations' => $users,
                'new_conversations_html' => view('chat.partials.users', compact('users'))->render(),
                'message' => "Conversations fetched successfully."
            ]);
        }

        $conversations = Conversation::where("user_one_id", $userId)
            ->orWhere("user_two_id", $userId)
            ->orderBy('last_message_at', 'desc')
            ->with(['user1', 'user2', 'messages' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }])
            ->withCount(['messages as unread_count' => function ($query) use ($userId) {
                $query->where('is_read', false)
                    ->where('sender_id', '!=', $userId);
            }])
            ->get()
            ->map(function ($conversation) use ($userId) {
                $conversation->other_user = $conversation->user_one_id === $userId
                    ? $conversation->user2
                    : $conversation->user1;
                $conversation->last_message = $conversation->messages->first();
                return $conversation;
            });

        return view('chat.index', compact('conversations'));
    }

    // public function show(Conversation $conversation)
    // {
    //     // Add authorization check here
    //     return view('chat.show', compact('conversation'));
    // }
    public function show(Request $request)
    {
        $userId = Auth::id(); // استبدل بـ Auth::id() للحصول على ID المستخدمسجل دخوله
        $serch = $request->input('serch');

        $conversations = User::whereAny(["name", "email"], 'LIKE', "%$serch%")
            ->where('id', '!=', $userId) // استبعاد المستخدم الحالي
            ->limit(15)
            ->get(['id', 'name', "email"]);
        return response()->json([
            'conversations' => $conversations,
            'message' => "Conversations fetched successfully."
        ]);
    }
    public function store(ConversationRequest $request)
    {

        $conversation = Conversation::create([
            'user_one_id' => Auth::id(),
            'user_two_id' => $request->input('user_two_id'),
        ])->load('messages', 'user1:id,name,email', 'user2:id,name,email');

        // إعادة بناء البيانات مع تغيير اسم
        $conversationEventData = $conversation->toArray();
        $conversationEventData['other_user'] = $conversationEventData['user1'];
        unset($conversationEventData['user1'], $conversationEventData['user2']);
        event(new NewConversationEvent($conversationEventData));

        $conversationData = $conversation->toArray();
        $conversationData['other_user'] = $conversationData['user2'];
        unset($conversationData['user1'], $conversationData['user2']); // إزالة المفتاح القديم

        return response()->json([
            'conversation' => $conversationData,
            'message' => 'Conversation created successfully.',
        ]);
    }
    public function isOpenConversation(Conversation $conversationId)
    {
        $isNotReadMessages = $conversationId->messages->where('is_read', '!=', true)
            ->where('sender_id', '!=', Auth::id());
        foreach ($isNotReadMessages as $message) {
            $message->update(['is_read' => true]);
        }
        if (sizeof($isNotReadMessages) > 0) {

            // dd($isNotReadMessages);
            broadcast(new IsReadeMssages($conversationId->id, $isNotReadMessages));
        }
        return response()->json(['message' => 'Conversation opened successfully.', "isNotReadMessages" => $isNotReadMessages]);
    }
    public function destroy() {}
}
