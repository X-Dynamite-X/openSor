<div class="bg-white/5 p-4 border-t border-blue-700 ">
    <form class="flex space-x-2">
        @csrf
        <div class="flex-1 relative">
            <input type="text" id="messageInput"
                class="w-full bg-white/10 text-white rounded-lg pl-4 pr-10 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500"
                placeholder="Type your message here...">
            <button type="button" class="absolute right-2 top-2 text-cyan-300 hover:text-cyan-400">
                <i class="fas fa-paperclip"></i>
            </button>
        </div>
        <button type="button" onclick="sendmessage()"
            class="bg-gradient-to-r from-blue-600 to-cyan-600 text-white rounded-lg px-4 py-2 hover:from-blue-700 hover:to-cyan-700 transition-colors">
            <i class="fas fa-paper-plane"></i>
        </button>
    </form>
</div>
