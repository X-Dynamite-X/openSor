
    <!-- Chat Header -->
    @include('chat.components.chatHeader',['user' => $user])
    <!-- Chat Messages -->
    @include('chat.components.chatMessage',['messages'=>$messages,'user' => $user])
    <!-- Chat Input -->
    @include('chat.components.chatInput')
