
<div class="bg-gradient-to-r from-blue-900 to-cyan-800 p-4 border-b border-blue-700" id="chat_header" data-user_id={{$user->id}} data-conversation_active="{{$conversation->id}}" >
    <div class="flex items-center space-x-4">
        <div class="relative">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" alt="User Avatar" class="w-10 h-10 rounded-full">
            <span
                class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
        </div>
        <div>
            <h3 class="text-lg font-semibold text-white">{{$user->name}}</h3>
         </div>
    </div>
</div>
