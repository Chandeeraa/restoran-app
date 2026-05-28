<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ request()->cookie('darkMode') === 'true' ? 'dark' : 'light' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>POS Terminal - {{ config('app.name', 'Restoran App') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Bootstrap & FontAwesome Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">



        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Outfit', sans-serif; }
            [x-cloak] { display: none !important; }
            /* Hide scrollbar for category and table lists */
            .no-scrollbar::-webkit-scrollbar {
                display: none;
            }
            .no-scrollbar {
                -ms-overflow-style: none;  /* IE and Edge */
                scrollbar-width: none;  /* Firefox */
            }
        </style>
    </head>
    <body x-data="{ darkMode: {{ request()->cookie('darkMode') === 'true' ? 'true' : 'false' }} }"
          x-init="
            $watch('darkMode', val => { 
                document.cookie = 'darkMode=' + val + '; path=/; max-age=31536000'; 
                if(val) document.documentElement.classList.add('dark'); 
                else document.documentElement.classList.remove('dark');
            });
          "
          class="font-sans antialiased text-gray-900 bg-[#F4F7F6] dark:bg-slate-900 dark:text-slate-100 h-screen overflow-hidden flex transition-colors duration-300">
        
        <!-- Livewire Component will render here -->
        {{ $slot }}

    </body>
</html>
