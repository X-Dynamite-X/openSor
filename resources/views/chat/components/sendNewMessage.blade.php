<div class="flex items-start space-x-2 animate-fade-in-down justify-end ">

    <div class="bg-cyan-800/50 rounded-lg rounded-tr-none p-3 max-w-[80%] order-1">
        <p class="text-white">{{ $message->text }}</p>
        <span class="text-xs text-cyan-300 mt-1 block">{{ $message->created_at }}</span>
    </div>

    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" alt="My Avatar"
        class="w-8 h-8 rounded-full order-2">

</div>
