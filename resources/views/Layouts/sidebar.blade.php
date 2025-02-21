<div class="w-64 bg-white bg-opacity-10 backdrop-blur-lg shadow-lg border-r border-white border-opacity-20">
    <!-- Logo Section -->
    <div class="p-4 border-b border-white border-opacity-20">
        <div class="flex items-center justify-center">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-auto">
        </div>
    </div>

    <!-- Admin Info -->
    <div class="p-4 border-b border-white border-opacity-20">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center">
                <i class="fas fa-user text-white"></i>
            </div>
            <div>
                <div class="text-white font-medium">{{ auth()->user()->name }}</div>
                <div class="text-white text-opacity-70 text-sm">Administrator</div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="p-4">
        <div class="space-y-2">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" 
               class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-white bg-opacity-20 text-white' : 'text-white text-opacity-70 hover:bg-white hover:bg-opacity-10 transition duration-200' }}">
                <i class="fas fa-home w-6"></i>
                <span>Dashboard</span>
            </a>

            <!-- Users Management -->
            <a href="{{ route('dashboard.users') }}" 
               class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('dashboard.users') ? 'bg-white bg-opacity-20 text-white' : 'text-white text-opacity-70 hover:bg-white hover:bg-opacity-10 transition duration-200' }}">
                <i class="fas fa-users w-6"></i>
                <span>Users</span>
            </a>

            <!-- Settings -->
            <a href="{{ route('settings') }}" 
               class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('settings') ? 'bg-white bg-opacity-20 text-white' : 'text-white text-opacity-70 hover:bg-white hover:bg-opacity-10 transition duration-200' }}">
                <i class="fas fa-cog w-6"></i>
                <span>Settings</span>
            </a>

            <!-- Reports -->
            <a href="{{ route('reports') }}" 
               class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('reports') ? 'bg-white bg-opacity-20 text-white' : 'text-white text-opacity-70 hover:bg-white hover:bg-opacity-10 transition duration-200' }}">
                <i class="fas fa-chart-bar w-6"></i>
                <span>Reports</span>
            </a>
        </div>

        <!-- Logout Button -->
        <div class="absolute bottom-4 w-56">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="w-full flex items-center space-x-3 p-3 rounded-lg text-white text-opacity-70 hover:bg-red-500 hover:text-white transition duration-200">
                    <i class="fas fa-sign-out-alt w-6"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </nav>
</div>