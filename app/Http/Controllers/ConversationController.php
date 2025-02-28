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
use App\Events\testEvents;

class ConversationController extends Controller
{
    //
    public function index(Request $request)
    {
        $userId = Auth::id();
        $currentUser = Auth::user();

        if ($request->ajax()) {
            $users = collect();

            if ($request->has('search')) {
                $searchTerm = $request->search;

                // استرداد قائمة المستخدمين الموجودين في محادثات مع المستخدم الحالي
                $existingConversationUsers = Conversation::where(function ($query) use ($userId) {
                    $query->where('user_one_id', $userId)
                        ->orWhere('user_two_id', $userId);
                })
                    ->get()
                    ->flatMap(function ($conversation) use ($userId) {
                        return [$conversation->user_one_id, $conversation->user_two_id];
                    })
                    ->unique()
                    ->values()
                    ->all();

                // إنشاء query builder أساسي
                $query = User::whereAny(["name", "email"], 'LIKE', "%$searchTerm%")
                    ->where('id', '!=', $userId) // استبعاد المستخدم الحالي
                    ->whereNotIn('id', $existingConversationUsers);

                // إذا لم يكن المستخدم أدمن، نقوم بتصفية المستخدمين حسب المواد المشتركة
                if (!$currentUser->hasRole('admin')) {
                    // الحصول على معرفات المواد التي يدرسها المستخدم الحالي
                    $userSubjectIds = $currentUser->subjects()->pluck('subjects.id');

                    $query->whereHas('subjects', function($q) use ($userSubjectIds) {
                        $q->whereIn('subjects.id', $userSubjectIds);
                    });
                }

                $users = $query->limit(15)->get(['id', 'name', 'email']);
            }

            return response()->json([
                'conversations' => $users,
                'new_conversations_html' => view('chat.partials.users', compact('users'))->render(),
                'message' => "Conversations fetched successfully."
            ]);
        }

        // استرداد المحادثات الحالية للمستخدم
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


    public function show(Conversation $conversation)
    {
        $messages = $conversation->messages;

        $user = $conversation->user1->id === auth()->id() ? $conversation->user2 : $conversation->user1;

        $isNotReadMessages = $conversation->messages->where('is_read', '!=', true)
            ->where('sender_id', '!=', auth()->id());
        foreach ($isNotReadMessages as $message) {
            $message->update(['is_read' => true]);
        }
        event(new testEvents('hello world'));

        $messages_conversation_html = view(  'chat.partials.chatConvestion', compact('messages', 'user',"conversation"))->render();
        return response([
            'messages_conversation_html' => $messages_conversation_html,
            "messages" => "Show conversation successfully."
        ]);
    }
    public function store(ConversationRequest $request)
    {
        // إنشاء المحادثة
        $conversation = Conversation::create([
            'user_one_id' => Auth::id(),
            'user_two_id' => $request->input('user_two_id'),
        ])->load('user1:id,name,email', 'user2:id,name,email');

        // تحديد المستخدم الآخر
        $otherUser = $conversation->user_one_id === Auth::id()
            ? $conversation->user2
            : $conversation->user1;

        // تحويل البيانات إلى مصفوفة
        $conversationData = $conversation->toArray();
        $conversationData['other_user'] = $otherUser;

        // إرسال حدث لإشعار النظام
        $newConversationHtml = view('chat.partials.resaveNewConvestion', compact('conversation', 'otherUser'))->render();

        event(new NewConversationEvent($conversationData,$newConversationHtml));

        // إعادة HTML جديد
        $messages = $conversation->messages;
        $user = $otherUser;
        $messages_conversation_html = view(  'chat.partials.chatConvestion', compact("conversation",'messages', 'user'))->render();
        $newConversationHtml = view('chat.partials.newConversation', compact('conversation', 'otherUser'))->render();

        // إرجاع الاستجابة JSON
        return response()->json([
            'conversation' => $conversationData,
            'new_conversation_html' => $newConversationHtml,
            "messages_conversation_html"=>$messages_conversation_html,
            'message' => 'Conversation created successfully.',
        ]);
    }
    // public function isOpenConversation(Conversation $conversationId)
    // {
    //     $isNotReadMessages = $conversationId->messages->where('is_read', '!=', true)
    //         ->where('sender_id', '!=', Auth::id());
    //     foreach ($isNotReadMessages as $message) {
    //         $message->update(['is_read' => true]);
    //     }
    //     if (sizeof($isNotReadMessages) > 0) {

    //         // dd($isNotReadMessages);
    //         // broadcast(new IsReadeMssages($conversationId->id, $isNotReadMessages));
    //     }
    //     return response()->json(['message' => 'Conversation opened successfully.', "isNotReadMessages" => $isNotReadMessages]);
    // }
    public function destroy() {}
}
