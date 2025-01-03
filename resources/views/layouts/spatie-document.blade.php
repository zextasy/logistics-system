<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Document') }}</title>

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    {{--    @vite('resources/css/document.css', 'resources/css/app.css')--}}
    <!-- Header Scripts -->

</head>

<body class="grid min-h-screen place-items-center bg-gray-400">
<!-- Page Content -->
<main class="h-[297mm] w-[210mm] overflow-hidden rounded-md bg-white p-8 shadow-lg">
    {{ $slot }}
</main>
<!-- Footer Scripts -->
</body>
</html>
