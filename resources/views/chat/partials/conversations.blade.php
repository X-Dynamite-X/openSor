<div class="overflow-y-auto h-[84vh] max-h-[84] min-h-[84vh]" id="conversation_list">
    @forelse ($conversations as $conversation)
        <div class="p-3 hover:bg-white/5 cursor-pointer " id="conversation_{{$conversation->id}}"
            onclick="getMessageConversation({{$conversation->id}})">
            <div class="flex items-center space-x-3">
                <div class="relative">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($conversation->other_user->name) }}&background=random"
                        alt="{{ $conversation->other_user->name }}" class="w-12 h-12 rounded-full">
                    <span
                        class="absolute bottom-0 right-0 w-3 h-3 bg-gray-500 border-2 border-white rounded-full"></span>
                </div>

                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <h4 class="text-white font-medium" >{{ $conversation->other_user->name }}</h4>
                        <span class="text-xs text-cyan-300" id="last_message_at_{{$conversation->id}}">
                            {{ $conversation->last_message ? $conversation->last_message_at : 'New' }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <p class="text-gray-300 text-sm truncate" id="last_message_text_{{$conversation->id}}">
                            {{ $conversation->last_message ? $conversation->last_message->text : 'No messages yet' }}
                        </p>
                        @if ($conversation->unread_count > 0)
                            <span class="bg-cyan-500 text-white text-xs rounded-full px-2 py-1 ml-2" id="unread_count">
                                {{ $conversation->unread_count }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="p-4 text-center text-gray-400" id="no_conversations">
            <p>No conversations yet</p>
        </div>
    @endforelse
</div>
