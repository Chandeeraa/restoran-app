<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Restoran App') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Outfit', sans-serif; }
        </style>
    </head>
    <body class="font-sans antialiased text-gray-900 bg-slate-50 relative overflow-x-hidden min-h-screen">
        <!-- Vibrant Background Blobs -->
        <div class="fixed inset-0 z-[-1] overflow-hidden pointer-events-none">
            <div class="absolute top-[-10%] right-[-5%] w-[40%] h-[40%] rounded-full bg-gradient-to-br from-orange-300/20 to-red-400/20 blur-[80px]"></div>
            <div class="absolute bottom-[-10%] left-[-10%] w-[50%] h-[50%] rounded-full bg-gradient-to-tr from-blue-400/20 to-indigo-500/20 blur-[100px]"></div>
            <div class="absolute top-[40%] left-[20%] w-[30%] h-[30%] rounded-full bg-gradient-to-br from-purple-300/20 to-pink-300/20 blur-[80px]"></div>
        </div>

        <div class="min-h-screen flex flex-col">
            <div class="sticky top-0 z-50 shadow-sm/50 backdrop-blur-xl bg-white/80 border-b border-gray-100/50">
                <livewire:layout.navigation />
            </div>

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white/40 backdrop-blur-md shadow-sm border-b border-white/50 relative z-10">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="flex-1 relative z-10">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
