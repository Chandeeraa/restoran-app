<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Restoran App') }} - Fresh & Delicious</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:400,600,800&display=swap" rel="stylesheet" />
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="antialiased bg-gray-50 text-gray-900 overflow-x-hidden selection:bg-orange-500 selection:text-white">

    <!-- Navigation -->
    <nav class="absolute w-full z-50 top-0 py-6 px-6 lg:px-12 flex justify-between items-center">
        <div class="flex items-center gap-2">
            <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-red-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-orange-500/30">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
            </div>
            <span class="text-2xl font-extrabold tracking-tight text-white drop-shadow-md">Restoran<span class="text-orange-400">App</span></span>
        </div>
        
        <div>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="font-semibold text-white hover:text-orange-200 transition-colors drop-shadow-md">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="font-semibold px-5 py-2.5 rounded-full bg-white/20 hover:bg-white/30 backdrop-blur-md border border-white/30 text-white transition-all shadow-lg hover:shadow-xl">Staff Login</a>
                @endauth
            @endif
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative min-h-screen flex items-center justify-center pt-20 pb-12 overflow-hidden bg-gradient-to-br from-slate-900 via-indigo-900 to-slate-900">
        
        <!-- Abstract Background Shapes -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
            <div class="absolute -top-[10%] -right-[10%] w-[50%] h-[50%] rounded-full bg-gradient-to-br from-orange-500/40 to-red-600/40 blur-[100px] animate-pulse"></div>
            <div class="absolute bottom-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-gradient-to-br from-blue-500/30 to-indigo-600/30 blur-[120px]"></div>
            <div class="absolute top-[40%] left-[20%] w-[30%] h-[30%] rounded-full bg-gradient-to-br from-purple-500/20 to-pink-500/20 blur-[90px]"></div>
        </div>

        <div class="relative z-10 w-full max-w-7xl px-6 lg:px-12 flex flex-col lg:flex-row items-center gap-12">
            
            <!-- Hero Content -->
            <div class="flex-1 text-center lg:text-left pt-10 lg:pt-0">
                <span class="inline-block py-1.5 px-4 rounded-full bg-orange-500/20 border border-orange-500/30 text-orange-400 font-semibold text-sm mb-6 shadow-sm backdrop-blur-md">
                    ✨ The Best Taste in Town
                </span>
                <h1 class="text-5xl lg:text-7xl font-extrabold text-white tracking-tight leading-tight mb-6 drop-shadow-xl">
                    Savor the <br/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-red-500 drop-shadow-sm">Extraordinary</span>
                </h1>
                <p class="text-lg lg:text-xl text-indigo-100/80 mb-10 max-w-2xl mx-auto lg:mx-0 font-light leading-relaxed">
                    Experience culinary excellence with our curated menus. Order directly from your table or pick up your favorites for takeaway.
                </p>
                
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                    <a href="{{ route('order') }}" class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-orange-500 to-red-500 text-white font-bold rounded-2xl shadow-lg shadow-orange-500/40 hover:shadow-orange-500/60 hover:-translate-y-1 transition-all duration-300 text-lg flex items-center justify-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        Order Now
                    </a>
                    <a href="#features" class="w-full sm:w-auto px-8 py-4 bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold rounded-2xl backdrop-blur-md transition-all duration-300 text-lg flex items-center justify-center">
                        View Features
                    </a>
                </div>
            </div>

            <!-- Hero Image/Graphic -->
            <div class="flex-1 w-full max-w-lg lg:max-w-none relative group hidden md:block">
                <div class="absolute inset-0 bg-gradient-to-tr from-orange-500 to-indigo-500 rounded-[3rem] blur-2xl opacity-40 group-hover:opacity-60 transition-opacity duration-500"></div>
                <div class="relative bg-white/10 backdrop-blur-xl border border-white/20 p-4 rounded-[3rem] shadow-2xl transform rotate-3 group-hover:rotate-0 transition-transform duration-500">
                    <!-- Mockup of the Order Page -->
                    <div class="bg-gray-50 rounded-[2.5rem] overflow-hidden aspect-[4/3] flex flex-col relative shadow-inner">
                        <div class="bg-white px-6 py-4 flex justify-between items-center shadow-sm z-10">
                            <div class="font-bold text-lg text-gray-800">Our Menu</div>
                            <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center text-orange-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                        </div>
                        <div class="p-6 grid grid-cols-2 gap-4">
                            <!-- Mock Menu Cards -->
                            <div class="bg-white rounded-2xl p-3 shadow-sm border border-gray-100">
                                <div class="w-full h-24 bg-gray-200 rounded-xl mb-3 animate-pulse"></div>
                                <div class="h-4 w-3/4 bg-gray-200 rounded mb-2"></div>
                                <div class="h-4 w-1/2 bg-orange-200 rounded"></div>
                            </div>
                            <div class="bg-white rounded-2xl p-3 shadow-sm border border-gray-100">
                                <div class="w-full h-24 bg-gray-200 rounded-xl mb-3 animate-pulse"></div>
                                <div class="h-4 w-3/4 bg-gray-200 rounded mb-2"></div>
                                <div class="h-4 w-1/2 bg-orange-200 rounded"></div>
                            </div>
                            <div class="bg-white rounded-2xl p-3 shadow-sm border border-gray-100">
                                <div class="w-full h-24 bg-gray-200 rounded-xl mb-3 animate-pulse"></div>
                                <div class="h-4 w-3/4 bg-gray-200 rounded mb-2"></div>
                                <div class="h-4 w-1/2 bg-orange-200 rounded"></div>
                            </div>
                            <div class="bg-white rounded-2xl p-3 shadow-sm border border-gray-100 opacity-50">
                                <div class="w-full h-24 bg-gray-200 rounded-xl mb-3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Modern Dining Experience</h2>
                <p class="mt-4 text-lg text-gray-500">Everything you need for a seamless and enjoyable restaurant visit.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="bg-gray-50 rounded-3xl p-8 hover:-translate-y-2 transition-transform duration-300 border border-gray-100">
                    <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Digital Menu</h3>
                    <p class="text-gray-600">Scan the QR code on your table to instantly view our vibrant, up-to-date catalog of delicious meals.</p>
                </div>
                
                <div class="bg-gray-50 rounded-3xl p-8 hover:-translate-y-2 transition-transform duration-300 border border-gray-100">
                    <div class="w-14 h-14 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Instant Orders</h3>
                    <p class="text-gray-600">Place your order directly from your smartphone. It goes straight to the kitchen display in real-time.</p>
                </div>

                <div class="bg-gray-50 rounded-3xl p-8 hover:-translate-y-2 transition-transform duration-300 border border-gray-100">
                    <div class="w-14 h-14 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Easy Checkout</h3>
                    <p class="text-gray-600">Enjoy your meal and head to the cashier when ready. We support Cash, QRIS, and Card payments seamlessly.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-slate-900 py-10 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-2 text-white">
                <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                </div>
                <span class="font-bold">RestoranApp</span>
            </div>
            <p class="text-slate-400 text-sm">
                &copy; {{ date('Y') }} Restoran App. Crafted for culinary excellence.
            </p>
        </div>
    </footer>

</body>
</html>
