<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Restoran App') }} - Staff Access</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Outfit', sans-serif; }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden bg-gradient-to-br from-slate-900 via-indigo-900 to-slate-900">
            
            <!-- Abstract Background Shapes for Restaurant Vibe -->
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
                <div class="absolute -top-[10%] -right-[10%] w-[50%] h-[50%] rounded-full bg-gradient-to-br from-orange-500/40 to-red-600/40 blur-[100px] animate-pulse"></div>
                <div class="absolute bottom-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-gradient-to-br from-blue-500/30 to-indigo-600/30 blur-[120px]"></div>
            </div>

            <div class="z-10 text-center mb-6">
                <a href="/" wire:navigate class="flex flex-col items-center gap-3">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-400 to-red-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-orange-500/30">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                    </div>
                    <h1 class="text-3xl font-extrabold tracking-tight text-white drop-shadow-md">Restoran<span class="text-orange-400">App</span></h1>
                </a>
            </div>

            <div class="z-10 w-full sm:max-w-md px-8 py-10 bg-white/95 backdrop-blur-xl shadow-2xl overflow-hidden sm:rounded-[2rem] border border-white/20">
                {{ $slot }}
            </div>
            
            <div class="z-10 mt-8 text-indigo-200/60 text-sm">
                &copy; {{ date('Y') }} Restoran App. Internal System.
            </div>
        </div>
    </body>
</html>
