@forelse ($users as $user)
    <div class="p-3 hover:bg-white/5 cursor-pointer {{ request()->query('chat') == $user->id ? 'bg-white/5' : '' }}"
        onclick="createConversation({{$user->id}})">
        
        <div class="flex items-center space-x-3">
            <div class="relative">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random"
                    alt="{{ $user->name }}" class="w-12 h-12 rounded-full">
                <span class="absolute bottom-0 right-0 w-3 h-3 bg-gray-500 border-2 border-white rounded-full"></span>
            </div>

            <div class="flex-1">
                <div class="flex justify-between items-start">
                    <h4 class="text-white font-medium">{{ $user->name }}</h4>

                </div>

                <div class="flex items-center justify-between">
                    <p class="text-gray-300 text-sm truncate">
                        Add To Conversation
                    </p>

                </div>
            </div>
        </div>
    </div>
@empty
    <div class="p-4 text-center text-gray-400">
        <p>No users yet</p>
    </div>
@endforelse
