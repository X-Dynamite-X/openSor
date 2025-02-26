<div class="flex-1 overflow-y-auto p-4 space-y-4 max-h-[77vh]" id="chat_messages">
    <!-- Messages Loop -->
    @foreach ($messages as $message)
        <div
            class="flex items-start space-x-2 animate-fade-in-down {{ $message->sender_id === Auth::id() ? 'justify-end' : '' }}">
            @if ($message->sender_id !== Auth::id())
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random"
                    alt="User Avatar" class="w-8 h-8 rounded-full">
            @endif
            <div
                class="{{ $message->sender_id === Auth::id()
                    ? 'bg-cyan-800/50 rounded-lg rounded-tr-none p-3 max-w-[80%] order-1'
                    : 'bg-blue-900/50 rounded-lg rounded-tl-none p-3 max-w-[80%]' }}">
                <p class="text-white">{{ $message->text }}</p>
                <span class="text-xs text-cyan-300 mt-1 block">{{ $message->created_at  }}</span>
            </div>
            @if ($message->sender_id === Auth::id())
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random"
                    alt="My Avatar" class="w-8 h-8 rounded-full order-2">
            @endif
        </div>
    @endforeach
</div>

