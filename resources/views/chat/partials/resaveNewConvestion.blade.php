<div class="p-3 hover:bg-white/5 cursor-pointer"
     onclick="getMessageConversation({{ $conversation->id }})">
    <div class="flex items-center space-x-3">
        <div class="relative">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($conversation->user1->name) }}&background=random"
                 alt="{{ $conversation->user1->name }}" class="w-12 h-12 rounded-full">
            <span class="absolute bottom-0 right-0 w-3 h-3 bg-gray-500 border-2 border-white rounded-full"></span>
        </div>
        <div class="flex-1">
            <div class="flex justify-between items-start">
                <h4 class="text-xs text-cyan-300 font-medium" id="last_message_at_{{$conversation->id}}">{{ $conversation->user1->name }}</h4>
                <span class="text-xs text-cyan-300">New</span>
            </div>
            <div class="text-gray-300 text-sm  flex items-center justify-between" id="last_message_text_{{$conversation->id}}">
                <p class="text-gray-300 text-sm truncate">No messages yet</p>
            </div>
        </div>
    </div>
</div>
