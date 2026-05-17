<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Restoran App') }} - Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Tailwind Play CDN (Shortcut / Workaround for secured PC environment) -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        colors: {
                            brand: {
                                orange: '#f5a623',
                                yellow: '#f8c23a',
                                green: '#7ed321',
                                cream: '#fcfaf2'
                            }
                        },
                        fontFamily: {
                            sans: ['Outfit', 'sans-serif'],
                        }
                    }
                }
            }
        </script>
        
        <style>
            body { font-family: 'Outfit', sans-serif; }
        </style>
    </head>
    <body class="font-sans antialiased text-gray-900 bg-brand-cream min-h-screen">
        <div class="min-h-screen flex w-full">
            
            <!-- Left Side: Image / Graphics -->
            <div class="hidden md:flex md:w-5/12 lg:w-1/2 relative bg-brand-yellow overflow-hidden items-center justify-center" style="clip-path: polygon(0 0, 100% 0, 85% 100%, 0% 100%);">
                
                <!-- Logo -->
                <div class="absolute top-8 left-8 flex items-center gap-2 z-20">
                    <div class="w-10 h-10 bg-white/50 backdrop-blur-sm rounded-full flex items-center justify-center shadow-md">
                        <i class="fa-solid fa-mug-hot text-[#5c3a21] text-lg drop-shadow-sm"></i>
                    </div>
                    <span class="font-serif font-bold text-xl tracking-widest text-[#5c3a21] drop-shadow-sm mt-1">YON RESTO</span>
                </div>
                
                <!-- Background decorative shapes -->
                <div class="absolute inset-0 z-0 opacity-20">
                    <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                        <path d="M-50,200 Q150,-50 300,100 T700,300" fill="none" stroke="black" stroke-width="3"/>
                        <path d="M100,500 Q250,150 500,400 T900,600" fill="none" stroke="black" stroke-width="2"/>
                        <circle cx="200" cy="150" r="40" fill="none" stroke="black" stroke-width="2"/>
                        <circle cx="600" cy="450" r="60" fill="none" stroke="black" stroke-width="3"/>
                    </svg>
                </div>
                
                <!-- Plates -->
                <div class="relative w-full h-full flex flex-col items-center justify-center p-10 mt-10">
                    <div class="w-80 h-80 rounded-full border-4 border-white shadow-2xl overflow-hidden z-10 -ml-20 mb-8 transform hover:scale-105 transition-transform duration-500 bg-white">
                        <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Salad" class="w-full h-full object-cover">
                    </div>
                    <div class="w-56 h-56 rounded-full border-4 border-white shadow-xl overflow-hidden z-10 ml-40 -mt-20 transform hover:scale-105 transition-transform duration-500 bg-white">
                        <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Healthy Food" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>

            <!-- Right Side: Form -->
            <div class="w-full md:w-7/12 lg:w-1/2 flex items-center justify-center p-8 sm:p-12 relative bg-brand-cream">
                
                <!-- Subtle decorative zig-zag lines -->
                <div class="absolute top-1/4 right-10 text-brand-orange opacity-60 hidden sm:block">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                </div>
                <div class="absolute bottom-1/4 left-10 text-black opacity-30 hidden sm:block">
                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                </div>

                <div class="w-full max-w-md z-10">
                    <!-- Mobile Logo -->
                    <div class="md:hidden flex items-center justify-center mb-8 gap-2">
                        <div class="w-12 h-12 bg-white/80 backdrop-blur-sm rounded-full flex items-center justify-center shadow-md">
                            <i class="fa-solid fa-mug-hot text-[#5c3a21] text-xl drop-shadow-sm"></i>
                        </div>
                        <span class="font-serif font-bold text-3xl tracking-widest text-[#5c3a21] drop-shadow-sm mt-1">YON RESTO</span>
                    </div>

                    {{ $slot }}
                </div>
            </div>

        </div>
    </body>
</html>
