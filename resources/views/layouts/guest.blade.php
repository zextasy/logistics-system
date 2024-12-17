<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Logistics System') }}</title>
    <meta name="description" content="Professional logistics and shipping solutions for businesses and individuals">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
    <!-- Scripts -->
        @filamentStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
    <body class="antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Header/Navigation -->
        <header class="relative bg-white">
            <livewire:welcome.navigation />
        </header>
        <!-- Page Content -->
            {{ $slot }}
        @livewire('notifications')
    </div>
        <!-- Footer -->
        <footer class="bg-gray-50 dark:bg-gray-950" aria-labelledby="footer-heading">
            <p class="mt-2 py-5 text-center text-indigo-600 bg-white">© {{now()->year}} Logistics Solutions | <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
        </footer>
    @filamentScripts
</body>
</html>
