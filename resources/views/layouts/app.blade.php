<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      class="{{ request()->cookie('darkMode') === 'true' ? 'dark' : '' }}"
      x-data="{ darkMode: {{ request()->cookie('darkMode') === 'true' ? 'true' : 'false' }} }"
      x-init="$watch('darkMode', val => { 
          document.cookie = 'darkMode=' + val + '; path=/; max-age=31536000'; 
          if(val) document.documentElement.classList.add('dark'); 
          else document.documentElement.classList.remove('dark');
      })">
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
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body x-data="{ isNavigating: false }" 
          x-on:livewire:navigating.window="isNavigating = true" 
          x-on:livewire:navigated.window="isNavigating = false"
          class="font-sans antialiased text-gray-900 bg-slate-50 dark:bg-slate-900 dark:text-slate-100 relative overflow-x-hidden min-h-screen transition-colors duration-300">
          
        <!-- Prevent Rapid Clicks During Navigation -->
        <div x-show="isNavigating" x-cloak class="fixed inset-0 z-[9999] cursor-wait" style="background: transparent;"></div>

        <!-- Dark Mode Toggle Button (Top Right) -->
        <div class="fixed top-4 right-4 z-[60]">
            <button @click="darkMode = !darkMode" class="p-2.5 rounded-full bg-white/80 dark:bg-slate-800/80 backdrop-blur-md shadow-sm border border-gray-200 dark:border-slate-700 text-gray-600 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors focus:outline-none">
                <!-- Sun Icon for Light Mode -->
                <svg x-show="darkMode" x-cloak class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <!-- Moon Icon for Dark Mode -->
                <svg x-show="!darkMode" x-cloak class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
            </button>
        </div>

        <!-- Vibrant Background Blobs -->
        <div class="fixed inset-0 z-[-1] overflow-hidden pointer-events-none">
            <div class="absolute top-[-10%] right-[-5%] w-[40%] h-[40%] rounded-full bg-gradient-to-br from-orange-300/20 to-red-400/20 dark:from-blue-500/10 dark:to-indigo-600/10 blur-[80px] transition-colors duration-500"></div>
            <div class="absolute bottom-[-10%] left-[-10%] w-[50%] h-[50%] rounded-full bg-gradient-to-tr from-blue-400/20 to-indigo-500/20 dark:from-cyan-500/10 dark:to-blue-600/10 blur-[100px] transition-colors duration-500"></div>
            <div class="absolute top-[40%] left-[20%] w-[30%] h-[30%] rounded-full bg-gradient-to-br from-purple-300/20 to-pink-300/20 dark:from-slate-700/20 dark:to-blue-800/10 blur-[80px] transition-colors duration-500"></div>
        </div>

        <div class="min-h-screen flex w-full">
            <!-- Sidebar Navigation -->
            <div class="w-64 shrink-0 shadow-[4px_0_24px_rgba(0,0,0,0.02)] backdrop-blur-xl bg-white/80 dark:bg-slate-800/80 border-r border-gray-100/50 dark:border-slate-700/50 sticky top-0 h-screen overflow-y-auto hidden md:block z-50">
                <livewire:layout.navigation />
            </div>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col min-w-0 max-w-full relative z-10 overflow-hidden">
                <!-- Mobile Navigation Header (Shown only on small screens) -->
                <div class="md:hidden sticky top-0 z-50 shadow-sm/50 backdrop-blur-xl bg-white/80 dark:bg-slate-800/80 border-b border-gray-100/50 dark:border-slate-700/50 pr-16">
                    <livewire:layout.navigation />
                </div>

                <!-- Page Heading -->
                @if (isset($header))
                    <header class="bg-white/40 dark:bg-slate-800/40 backdrop-blur-md shadow-sm border-b border-white/50 dark:border-slate-700/50 relative z-10">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 pr-16 md:pr-8 text-gray-800 dark:text-slate-200">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <!-- Page Content -->
                <main class="flex-1 w-full relative z-10 p-4 sm:p-6 lg:p-8">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
