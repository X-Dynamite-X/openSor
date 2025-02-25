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
            <div class="overflow-y-auto h-[calc(100vh )] hidden" id="search_conversation_list"></div>
            <!-- Contacts List -->
            @include('chat.partials.conversations', ['conversations' => $conversations])


        </div>
        <!-- Chat Area -->
        <div class="flex-1 flex flex-col  overflow-y-scrole" id="chat_area">

    </div>
@endsection

@section('script')
    <script src="{{ asset('js/getConversiton.js') }}"></script>
    <script></script>

@endsection
