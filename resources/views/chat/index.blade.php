@extends('layouts.app')

@section('content')
    <div class="flex  bg-transparent">
        <!-- Sidebar -->
        <div class="w-80 bg-white/10 backdrop-blur-sm border-r border-white/20">
            <!-- Search Bar -->
            <div class="p-4 border-b border-white/20">
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Search contacts..."
                        class="w-full bg-white/10 text-white rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>
            <div class="overflow-y-auto h-[calc(100vh )] hidden"
            id="search_conversation_list"></div>
            <!-- Contacts List -->
            @include('chat.partials.conversations',['conversations'=> $conversations])
           

        </div>
        <!-- Chat Area -->
        <div class="flex-1 flex flex-col">
            <!-- Chat Header -->
            <div class="bg-gradient-to-r from-blue-900 to-cyan-800 p-4 border-b border-blue-700">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <img src="https://via.placeholder.com/40" alt="User Avatar" class="w-10 h-10 rounded-full">
                        <span
                            class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white">John Doe</h3>
                        <p class="text-cyan-300 text-sm">Online</p>
                    </div>
                </div>
            </div>
            <!-- Chat Messages -->
            <div class="flex-1 overflow-y-auto p-4 space-y-4" id="chat-messages">
                <!-- Received Message -->
                <div class="flex items-start space-x-2 animate-fade-in-down">
                    <img src="https://via.placeholder.com/32" alt="User Avatar" class="w-8 h-8 rounded-full">
                    <div class="bg-blue-900/50 rounded-lg rounded-tl-none p-3 max-w-[80%]">
                        <p class="text-white">Hello, how are you today?</p>
                        <span class="text-xs text-cyan-300 mt-1 block">10:30 AM</span>
                    </div>
                </div>

                <!-- Sent Message -->
                <div class="flex items-start justify-end space-x-2 animate-fade-in-down">
                    <div class="bg-cyan-800/50 rounded-lg rounded-tr-none p-3 max-w-[80%] order-1">
                        <p class="text-white">Hi! I'm doing great, thank you!</p>
                        <span class="text-xs text-cyan-300 mt-1 block">10:31 AM</span>
                    </div>
                    <img src="https://via.placeholder.com/32" alt="My Avatar" class="w-8 h-8 rounded-full order-2">
                </div>
            </div>

            <!-- Chat Input -->
            <div class="bg-white/5 p-4 border-t border-blue-700">
                <form class="flex space-x-2">
                    <div class="flex-1 relative">
                        <input type="text"
                            class="w-full bg-white/10 text-white rounded-lg pl-4 pr-10 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500"
                            placeholder="Type your message here...">
                        <button type="button" class="absolute right-2 top-2 text-cyan-300 hover:text-cyan-400">
                            <i class="fas fa-paperclip"></i>
                        </button>
                    </div>
                    <button type="submit"
                        class="bg-gradient-to-r from-blue-600 to-cyan-600 text-white rounded-lg px-4 py-2 hover:from-blue-700 hover:to-cyan-700 transition-colors">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/getConversiton.js') }}"></script>
 
@endsection
