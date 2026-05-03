<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Restaurant App') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Outfit', sans-serif; }
        </style>
    </head>
    <body class="font-sans antialiased text-gray-900 bg-slate-50 relative overflow-x-hidden min-h-screen pb-20">
        <!-- Vibrant Background Blobs -->
        <div class="fixed inset-0 z-[-1] overflow-hidden pointer-events-none">
            <div class="absolute top-[-5%] left-[-10%] w-[60%] h-[40%] rounded-full bg-gradient-to-br from-orange-400/10 to-red-500/10 blur-[80px]"></div>
            <div class="absolute bottom-[20%] right-[-10%] w-[50%] h-[50%] rounded-full bg-gradient-to-tl from-indigo-500/10 to-purple-500/10 blur-[100px]"></div>
        </div>

        <div class="relative z-10">
            {{ $slot }}
        </div>
    </body>
</html>
