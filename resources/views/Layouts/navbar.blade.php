<nav class="bg-white bg-opacity-10 backdrop-blur-lg shadow-lg border-b border-white border-opacity-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <h1 class="text-2xl font-bold text-white">Dashboard</h1>
            </div>
            @unless (request()->routeIs('dashboard.*'))
                <div class="flex items-center space-x-4">
                    @auth
                    @role('admin')
                        <div>
                            <a href="{{ route('dashboard.users') }}"
                                class="flex items-center p-3 rounded-lg {{ request()->routeIs('dashboard.users') ? 'bg-white bg-opacity-20 text-white' : 'text-white text-opacity-70 hover:bg-white hover:bg-opacity-10 transition duration-200' }}">
                                <i class="fas fa-users w-6"></i>
                                <span>Admin</span>
                            </a>
                        </div>
                    @endrole
                    @role('user')
                        <div>
                            <a href="{{ route('home') }}"
                                class="flex items-center p-3 rounded-lg {{ request()->routeIs('home') ? 'bg-white bg-opacity-20 text-white' : 'text-white text-opacity-70 hover:bg-white hover:bg-opacity-10 transition duration-200' }}">
                                <i class="fas fa-home w-6"></i>
                                <span>Home</span>
                            </a>
                        </div>
                    @endrole
                    <div>
                        <a href="{{ route('chat.index') }}"
                            class="flex items-center p-3 rounded-lg {{ request()->routeIs('message') ? 'bg-white bg-opacity-20 text-white' : 'text-white text-opacity-70 hover:bg-white hover:bg-opacity-10 transition duration-200' }}">
                            <i class="fas fa-comments w-6"></i>
                            <span>Message</span>
                        </a>
                    </div>
                    <div class="  bottom-4 ">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center space-x-3 p-3 rounded-lg text-white text-opacity-70 hover:bg-red-500 hover:text-white transition duration-200">
                                <i class="fas fa-sign-out-alt w-6"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                    @endauth
                </div>
            @endunless
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <button class="text-white hover:text-white/70 transition">
                        <i class="fas fa-bell text-xl"></i>
                    </button>

                    <!-- Notification badge -->
                    <div
                        class="absolute -top-1 -right-1 h-4 w-4 bg-red-500 rounded-full flex items-center justify-center">
                        <span class="text-white text-xs">3</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
