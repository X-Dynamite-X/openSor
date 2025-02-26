 
<div class="flex items-start space-x-2 animate-fade-in-down justify-start">
    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" alt="User Avatar"
        class="w-8 h-8 rounded-full">
    <div class="
        bg-blue-900/50 rounded-lg rounded-tl-none p-3 max-w-[80%] ">
        <p class="text-white">{{ $message->text }}</p>
        <span class="text-xs text-cyan-300 mt-1 block">{{ $message->created_at }}</span>
    </div>
</div>
