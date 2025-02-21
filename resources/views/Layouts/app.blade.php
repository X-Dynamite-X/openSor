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

    @yield('content')

    @yield('script')
    @yield('style')
 <script>

</script>
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
