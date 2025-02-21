<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard - {{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 min-h-screen">
    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            @include('layouts.navbar')

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-transparent">
                <div class="container mx-auto px-6 py-8">
                    <!-- Search Bar -->
                    <div class="mb-6">
                        <div class="relative">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" id="searchInput" placeholder="Search users..."
                                class="w-full sm:w-96 pl-10 pr-4 py-2 rounded-lg border border-white border-opacity-20 bg-white bg-opacity-10 backdrop-blur-lg text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                    </div>

                    <!-- Content Area -->
                    <div class="bg-white bg-opacity-10 backdrop-blur-lg shadow-lg rounded-lg overflow-hidden border border-white border-opacity-20">
                        <!-- Your existing table content goes here -->
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>
    @yield('model')
    @yield('loding')


    @yield('script')
    @yield('style')
    <style>
        @keyframes fade-in-down {
            0% {
                opacity: 0;
                transform: translateY(-10px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-down {
            animation: fade-in-down 0.3s ease-out;
        }
    </style>
</body>

</html>
