<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      class="{{ request()->cookie('darkMode') === 'true' ? 'dark' : '' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Restoran App') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800&display=swap" rel="stylesheet" />

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

        <!-- Restore Vite (In case you have a built manifest, it will load. If not, the CDN covers Tailwind) -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Outfit', sans-serif; }
            [x-cloak] { display: none !important; }

            /* Scrollbar CSS */
            ::-webkit-scrollbar { width: 8px; height: 8px; }
            ::-webkit-scrollbar-track { background: transparent; }
            ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
            ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
            .dark ::-webkit-scrollbar-track { background: transparent; }
            .dark ::-webkit-scrollbar-thumb { background: #334155; }
            .dark ::-webkit-scrollbar-thumb:hover { background: #475569; }
        </style>
    </head>
    <body x-data="{ 
            darkMode: {{ request()->cookie('darkMode') === 'true' ? 'true' : 'false' }},
            isNavigating: false, 
            sidebarOpen: localStorage.getItem('sidebarOpen') !== 'false' 
          }"
          x-init="
            $watch('darkMode', val => { 
                document.cookie = 'darkMode=' + val + '; path=/; max-age=31536000'; 
                if(val) document.documentElement.classList.add('dark'); 
                else document.documentElement.classList.remove('dark');
            });
            $watch('sidebarOpen', val => localStorage.setItem('sidebarOpen', val));
          "
          x-on:livewire:navigating.window="isNavigating = true" 
          x-on:livewire:navigated.window="isNavigating = false"
          class="font-sans antialiased text-gray-900 bg-brand-cream dark:bg-slate-900 dark:text-slate-100 relative overflow-x-hidden min-h-screen transition-colors duration-300">
          
        <!-- Prevent Rapid Clicks During Navigation -->
        <div x-show="isNavigating" x-cloak class="fixed inset-0 z-[9999] cursor-wait" style="background: transparent;"></div>

        <!-- Floating Controls (Top Right - Desktop Only) -->
        <div class="fixed top-4 right-4 z-[60] hidden md:flex items-center gap-3">
            <!-- Sidebar Toggle Button -->
            <button @click="sidebarOpen = !sidebarOpen" class="hidden md:flex p-2.5 rounded-full bg-white/80 dark:bg-slate-800/80 backdrop-blur-md shadow-sm border border-gray-200 dark:border-slate-700 text-gray-600 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors focus:outline-none items-center justify-center">
                <svg x-show="sidebarOpen" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                <svg x-show="!sidebarOpen" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
            </button>
            
            <!-- Dark Mode Toggle Button -->
            <button @click="darkMode = !darkMode" class="p-2.5 rounded-full bg-white/80 dark:bg-slate-800/80 backdrop-blur-md shadow-sm border border-gray-200 dark:border-slate-700 text-gray-600 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors focus:outline-none">
                <!-- Sun Icon for Light Mode -->
                <svg x-show="darkMode" x-cloak class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <!-- Moon Icon for Dark Mode -->
                <svg x-show="!darkMode" x-cloak class="w-5 h-5 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
            </button>
        </div>
        
        <!-- Decorative vibrant background for Dark Mode (Memphis/Fluid Style) -->
        <div class="fixed inset-0 z-[-1] overflow-hidden pointer-events-none hidden dark:block transition-colors duration-500">
            <svg width="100%" height="100%" preserveAspectRatio="none" viewBox="0 0 1440 900" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="dots-dark" x="0" y="0" width="25" height="25" patternUnits="userSpaceOnUse">
                        <circle cx="3" cy="3" r="3" fill="rgba(255,255,255,0.1)" />
                    </pattern>
                    <pattern id="stripes-dark" width="12" height="12" patternTransform="rotate(45 0 0)" patternUnits="userSpaceOnUse">
                        <line x1="0" y1="0" x2="0" y2="12" stroke="rgba(255,255,255,0.15)" stroke-width="4" />
                    </pattern>
                </defs>
                
                <!-- Top Left Shape -->
                <path d="M0,0 L500,0 C500,0 550,200 350,300 C150,400 0,350 0,350 Z" fill="#115e59" opacity="0.6" />
                <path d="M0,0 L350,0 C350,0 400,120 250,180 C50,250 0,200 0,200 Z" fill="url(#dots-dark)" />
                <path d="M-50,150 Q200,250 450,50" fill="none" stroke="#0d9488" stroke-width="3" opacity="0.4" />

                <!-- Top Right Shape -->
                <path d="M900,0 L1440,0 L1440,300 C1440,300 1250,350 1100,250 C950,150 900,0 900,0 Z" fill="#854d0e" opacity="0.5" />
                <path d="M1150,0 L1440,0 L1440,200 C1440,200 1300,250 1200,150 C1100,50 1150,0 1150,0 Z" fill="url(#dots-dark)" />

                <!-- Bottom Left Shape -->
                <path d="M0,500 C150,500 300,600 350,750 C400,900 350,900 350,900 L0,900 Z" fill="#b45309" opacity="0.4" />
                <rect x="50" y="550" width="150" height="150" fill="url(#dots-dark)" />

                <!-- Bottom Right Shapes -->
                <path d="M700,900 C800,700 1100,550 1440,600 L1440,900 Z" fill="#065f46" opacity="0.6" />
                <path d="M900,900 C1000,800 1200,700 1440,750 L1440,900 Z" fill="#0f766e" opacity="0.5" />
                <path d="M800,900 C950,700 1250,600 1440,550" fill="none" stroke="#10b981" stroke-width="2" opacity="0.3" />
                <rect x="1200" y="700" width="200" height="200" fill="url(#dots-dark)" />

                <!-- Neon Floating Elements -->
                <circle cx="350" cy="300" r="30" fill="#f59e0b" opacity="0.5" />
                <circle cx="350" cy="300" r="30" fill="url(#stripes-dark)" />
                
                <circle cx="1100" cy="220" r="35" fill="#10b981" opacity="0.4" />
                <circle cx="1100" cy="220" r="35" fill="url(#stripes-dark)" />
                
                <circle cx="750" cy="650" r="25" fill="#14b8a6" opacity="0.5" />
                <circle cx="750" cy="650" r="25" fill="url(#stripes-dark)" />
                
                <circle cx="-10" cy="550" r="30" fill="#10b981" opacity="0.4" />
                <circle cx="-10" cy="550" r="30" fill="url(#stripes-dark)" />

                <!-- Small Neon Solid Circles -->
                <circle cx="1050" cy="500" r="40" fill="#f59e0b" opacity="0.3" />
                <circle cx="1250" cy="680" r="20" fill="#f59e0b" opacity="0.4" />
                <circle cx="600" cy="700" r="12" fill="#10b981" opacity="0.5" />
                <circle cx="100" cy="650" r="10" fill="#14b8a6" opacity="0.5" />
                <circle cx="50" cy="180" r="8" fill="#f59e0b" opacity="0.6" />
                <circle cx="950" cy="220" r="10" fill="#f59e0b" opacity="0.5" />
                <circle cx="1150" cy="450" r="8" fill="#14b8a6" opacity="0.6" />
            </svg>
        </div>

        <!-- Decorative vibrant background for Light Mode (Memphis/Fluid Style) -->
        <div class="fixed inset-0 z-[-1] overflow-hidden pointer-events-none bg-[#fffdf0] dark:hidden transition-colors duration-500">
            <svg width="100%" height="100%" preserveAspectRatio="none" viewBox="0 0 1440 900" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="dots" x="0" y="0" width="25" height="25" patternUnits="userSpaceOnUse">
                        <circle cx="3" cy="3" r="3" fill="rgba(255,255,255,0.5)" />
                    </pattern>
                    <pattern id="stripes" width="12" height="12" patternTransform="rotate(45 0 0)" patternUnits="userSpaceOnUse">
                        <line x1="0" y1="0" x2="0" y2="12" stroke="#ffffff" stroke-width="4" opacity="0.6"/>
                    </pattern>
                </defs>
                
                <!-- Top Left Teal Shape -->
                <path d="M0,0 L500,0 C500,0 550,200 350,300 C150,400 0,350 0,350 Z" fill="#45c49d" />
                <path d="M0,0 L350,0 C350,0 400,120 250,180 C50,250 0,200 0,200 Z" fill="url(#dots)" />
                <path d="M-50,150 Q200,250 450,50" fill="none" stroke="#ffffff" stroke-width="4" opacity="0.8" />
                <path d="M-50,200 Q200,300 300,-50" fill="none" stroke="#ffffff" stroke-width="2" opacity="0.6" />

                <!-- Top Right Yellow Shape -->
                <path d="M900,0 L1440,0 L1440,300 C1440,300 1250,350 1100,250 C950,150 900,0 900,0 Z" fill="#ffd644" />
                <path d="M1150,0 L1440,0 L1440,200 C1440,200 1300,250 1200,150 C1100,50 1150,0 1150,0 Z" fill="url(#dots)" />
                <circle cx="1350" cy="120" r="15" fill="#45c49d" />

                <!-- Bottom Left Yellow Shape -->
                <path d="M0,500 C150,500 300,600 350,750 C400,900 350,900 350,900 L0,900 Z" fill="#ffd644" />
                <rect x="50" y="550" width="150" height="150" fill="url(#dots)" />

                <!-- Bottom Right Green Shapes -->
                <path d="M700,900 C800,700 1100,550 1440,600 L1440,900 Z" fill="#8de093" />
                <path d="M900,900 C1000,800 1200,700 1440,750 L1440,900 Z" fill="#45c49d" />
                <path d="M800,900 C950,700 1250,600 1440,550" fill="none" stroke="#ffffff" stroke-width="4" opacity="0.8" />
                <rect x="1200" y="700" width="200" height="200" fill="url(#dots)" />

                <!-- Floating Elements -->
                <!-- Striped Circles -->
                <circle cx="350" cy="300" r="30" fill="#ffd644" />
                <circle cx="350" cy="300" r="30" fill="url(#stripes)" />
                
                <circle cx="1100" cy="220" r="35" fill="#8de093" />
                <circle cx="1100" cy="220" r="35" fill="url(#stripes)" />
                
                <circle cx="750" cy="650" r="25" fill="#45c49d" />
                <circle cx="750" cy="650" r="25" fill="url(#stripes)" />
                
                <circle cx="-10" cy="550" r="30" fill="#8de093" />
                <circle cx="-10" cy="550" r="30" fill="url(#stripes)" />

                <!-- Solid Circles -->
                <circle cx="1050" cy="500" r="50" fill="#ffd644" />
                <circle cx="1250" cy="680" r="25" fill="#ffd644" />
                <circle cx="600" cy="700" r="15" fill="#8de093" />
                <circle cx="100" cy="650" r="12" fill="#45c49d" />
                <circle cx="50" cy="180" r="10" fill="#ffd644" />
                <circle cx="950" cy="220" r="12" fill="#ffd644" />
                <circle cx="1150" cy="450" r="10" fill="#45c49d" />
                
                <!-- Large Decorative White/Cream Circles -->
                <circle cx="250" cy="850" r="70" fill="#fffdf0" />
                <circle cx="1000" cy="680" r="15" fill="#fffdf0" />
                <circle cx="450" cy="50" r="20" fill="#fffdf0" />
            </svg>
        </div>

        <div class="min-h-screen flex w-full">
            <!-- Sidebar Navigation -->
            <div :class="sidebarOpen ? 'ml-0 translate-x-0' : '-ml-64 -translate-x-full opacity-0'" class="w-64 shrink-0 transition-all duration-300 ease-in-out shadow-[4px_0_24px_rgba(0,0,0,0.02)] backdrop-blur-xl bg-brand-cream/95 dark:bg-emerald-950/90 border-r border-gray-100/50 dark:border-emerald-900/50 sticky top-0 h-screen hidden md:block z-50 overflow-hidden">
                <div class="w-64 overflow-y-auto h-full overflow-x-hidden">
                    <livewire:layout.navigation />
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col min-w-0 max-w-full relative z-10 overflow-hidden">
                <!-- Mobile Navigation Header (Shown only on small screens) -->
                <div class="md:hidden sticky top-0 z-50 shadow-sm/50 backdrop-blur-xl bg-brand-cream/95 dark:bg-emerald-950/90 border-b border-gray-100/50 dark:border-emerald-900/50">
                    <livewire:layout.navigation />
                </div>

                <!-- Page Heading -->
                @if (isset($header))
                    <header class="bg-white/60 dark:bg-slate-800/40 backdrop-blur-md shadow-sm border-b border-white/50 dark:border-slate-700/50 relative z-10">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-gray-800 dark:text-slate-200">
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
