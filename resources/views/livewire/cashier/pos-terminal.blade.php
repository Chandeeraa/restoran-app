<div x-data="{ sidebarOpen: window.innerWidth >= 1024 }" class="flex h-screen bg-[#F4F7F6] dark:bg-slate-900 w-full overflow-hidden transition-colors duration-300 relative">
    
    <!-- Mobile Overlay (close sidebar when clicking outside) -->
    <div
        x-show="sidebarOpen && window.innerWidth < 1024"
        x-transition:enter="transition-opacity ease-linear duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="sidebarOpen = false"
        class="fixed inset-0 bg-black/40 z-20 lg:hidden"
        x-cloak
    ></div>

    <!-- Left Sidebar -->
    <div
        x-show="sidebarOpen"
        x-transition:enter="transition ease-in-out duration-300 transform"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in-out duration-300 transform"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="fixed lg:relative z-30 lg:z-auto w-64 bg-white dark:bg-slate-800 shadow-sm flex flex-col justify-between shrink-0 h-full border-r border-gray-100 dark:border-slate-700 transition-colors duration-300"
        x-cloak
    >
        <div class="p-6">
            <!-- Logo -->
            <div class="flex items-center gap-3 mb-10">
                <div class="w-10 h-10 bg-[#5c3a21]/10 dark:bg-[#5c3a21]/30 rounded-full flex items-center justify-center text-[#5c3a21] dark:text-[#d3a87c] font-bold text-xl drop-shadow-sm">
                    <i class="fa-solid fa-mug-hot"></i>
                </div>
                <span class="font-serif font-bold text-lg text-[#5c3a21] dark:text-[#d3a87c] tracking-wider">YON RESTO</span>
            </div>

            <!-- Nav Links -->
            <nav class="space-y-2">
                <button @click="if(window.innerWidth < 1024) sidebarOpen = false" wire:click="setTab('menu')" class="w-full flex items-center gap-3 px-4 py-3 {{ $activeTab === 'menu' ? 'bg-emerald-600 text-white' : 'text-gray-600 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700/50' }} rounded-full font-medium transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    Menu
                </button>
                <button @click="if(window.innerWidth < 1024) sidebarOpen = false" wire:click="setTab('tables')" class="w-full flex items-center gap-3 px-4 py-3 {{ $activeTab === 'tables' ? 'bg-emerald-600 text-white' : 'text-gray-600 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700/50' }} rounded-full font-medium transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Table Services
                </button>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-gray-600 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700/50 rounded-full font-medium transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Back to Dashboard
                </a>
            </nav>
        </div>

        <div class="p-6 border-t border-gray-100 dark:border-slate-700">
            <!-- Users profiles -->
            <div class="space-y-3 mb-6">
                <div class="flex items-center gap-3 px-3 py-2 border border-gray-100 dark:border-slate-700 rounded-full cursor-pointer hover:bg-gray-50 dark:hover:bg-slate-700/50">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold">
                        {{ substr(auth()->user()->name, 0, 2) }}
                    </div>
                    <span class="text-sm font-medium text-gray-700 dark:text-slate-300 truncate">{{ auth()->user()->name }}</span>
                </div>
            </div>
            
            <button wire:click="logout" class="flex items-center gap-3 text-gray-500 dark:text-slate-400 hover:text-red-600 dark:hover:text-red-400 font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Logout
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-full overflow-hidden relative min-w-0">
        <!-- Header -->
        <header class="h-16 md:h-20 flex items-center px-4 md:px-8 shrink-0 gap-3">
            <!-- Sidebar Toggle Button -->
            <button
                @click="sidebarOpen = !sidebarOpen"
                class="p-2.5 bg-white dark:bg-slate-800 rounded-full shadow-sm text-gray-500 dark:text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors border border-gray-100 dark:border-slate-700 shrink-0"
                :title="sidebarOpen ? 'Tutup menu' : 'Buka menu'"
            >
                <svg x-show="!sidebarOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                <svg x-show="sidebarOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="flex items-center flex-1 max-w-2xl relative mr-2">
                <div class="absolute left-4 text-gray-400 dark:text-slate-500 hidden md:block">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search..." class="w-full pl-4 md:pl-12 pr-4 py-2 md:py-3 bg-white dark:bg-slate-800 border-none rounded-full shadow-sm focus:ring-2 focus:ring-emerald-500 outline-none text-sm font-medium text-gray-700 dark:text-slate-200 placeholder-gray-400 dark:placeholder-slate-500 transition-colors">
            </div>
            <div class="ml-auto flex items-center gap-2 md:gap-4 shrink-0">
                <!-- Dark Mode Toggle -->
                <button @click="darkMode = !darkMode" class="p-2 md:p-3 bg-white dark:bg-slate-800 rounded-full shadow-sm text-gray-500 dark:text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors border border-gray-100 dark:border-slate-700">
                    <svg x-show="!darkMode" class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    <svg x-show="darkMode" x-cloak class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </button>

                @if($activeTab === 'menu')
                <!-- Order Type Toggle -->
                <div class="flex bg-white dark:bg-slate-800 rounded-full p-1 shadow-sm border border-gray-100 dark:border-slate-700 hidden sm:flex">
                    <button wire:click="$set('orderType', 'dine-in')" class="px-3 md:px-4 py-1 md:py-2 rounded-full text-xs md:text-sm font-bold transition-colors {{ $orderType === 'dine-in' ? 'bg-emerald-100 text-emerald-800' : 'text-gray-500 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-700' }}">
                        Dine-In
                    </button>
                    <button wire:click="$set('orderType', 'takeaway')" class="px-3 md:px-4 py-1 md:py-2 rounded-full text-xs md:text-sm font-bold transition-colors {{ $orderType === 'takeaway' ? 'bg-emerald-100 text-emerald-800' : 'text-gray-500 hover:bg-gray-50' }}">
                        Takeaway
                    </button>
                </div>
                <!-- Mobile Order Type Toggle -->
                <button wire:click="$set('orderType', '{{ $orderType === 'dine-in' ? 'takeaway' : 'dine-in' }}')" class="sm:hidden px-3 py-2 bg-emerald-100 text-emerald-800 rounded-full text-xs font-bold shadow-sm">
                    {{ $orderType === 'dine-in' ? 'Dine-In' : 'Takeaway' }}
                </button>
                
                <button wire:click="openCheckout" class="relative p-2 md:p-3 bg-white rounded-full shadow-sm text-gray-600 hover:text-emerald-600 transition-colors">
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    @if(count($cart) > 0)
                        <span class="absolute top-0 right-0 w-4 h-4 md:w-5 md:h-5 bg-red-500 text-white text-[10px] md:text-xs font-bold rounded-full flex items-center justify-center transform translate-x-1 -translate-y-1">{{ array_sum(array_column($cart, 'quantity')) }}</span>
                    @endif
                </button>
                @else
                <!-- Dashboard Info pill -->
                <div class="flex items-center gap-2 bg-white dark:bg-slate-800 rounded-full px-4 py-2 shadow-sm border border-gray-100 dark:border-slate-700">
                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                    <span class="text-sm font-bold text-gray-700 dark:text-slate-300">Live Services</span>
                </div>
                @endif
            </div>
        </header>

        @if($activeTab === 'menu')

        <!-- Categories -->
        <div class="px-4 md:px-8 mb-6 shrink-0 no-scrollbar overflow-x-auto">
            <div class="flex gap-3 md:gap-4 min-w-max pb-2">
                <button wire:click="setCategory(null)" class="flex flex-col items-center justify-center w-24 h-28 rounded-2xl transition-all shadow-sm {{ is_null($activeCategoryId) ? 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-800 dark:text-emerald-400 border-2 border-emerald-500' : 'bg-white dark:bg-slate-800 text-gray-500 dark:text-slate-400 border border-transparent' }}">
                    <div class="mb-2">
                        <i class="fas fa-th-large text-3xl"></i>
                    </div>
                    <span class="font-bold text-sm">All</span>
                    <span class="text-xs opacity-70 mt-1">{{ \App\Models\Menu::count() }} items</span>
                </button>
                @foreach($categories as $category)
                    <button wire:click="setCategory({{ $category->id }})" class="flex flex-col items-center justify-center w-28 h-28 rounded-2xl transition-all shadow-sm {{ $activeCategoryId == $category->id ? 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-800 dark:text-emerald-400 border-2 border-emerald-500' : 'bg-white dark:bg-slate-800 text-gray-500 dark:text-slate-400 border border-transparent hover:bg-gray-50 dark:hover:bg-slate-700/50' }}">
                        <div class="mb-2 text-emerald-600">
                            @if(strtolower($category->name) === 'makanan')
                                <i class="fas fa-utensils text-3xl"></i>
                            @elseif(strtolower($category->name) === 'minuman')
                                <i class="fas fa-glass-water text-3xl"></i>
                            @elseif(strtolower($category->name) === 'snack')
                                <i class="fas fa-hamburger text-3xl"></i>
                            @elseif(strtolower($category->name) === 'dessert')
                                <i class="fas fa-cheese text-3xl"></i>
                            @else
                                <i class="fas fa-utensils text-3xl"></i>
                            @endif
                        </div>
                        <span class="font-bold text-sm text-gray-800 dark:text-slate-200">{{ $category->name }}</span>
                        <span class="text-xs text-gray-400 mt-1">{{ $category->menus()->count() }} items</span>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Menu Grid -->
        <div class="flex-1 px-4 md:px-8 overflow-y-auto no-scrollbar pb-32">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @foreach($menus as $menu)
                    @php
                        $inCart = collect($cart)->firstWhere('id', $menu->id);
                    @endphp
                    <div class="bg-white dark:bg-slate-800 rounded-3xl p-4 shadow-sm flex flex-col transition-all border {{ $inCart ? 'border-emerald-500 border-2' : 'border-transparent dark:border-slate-700 hover:shadow-md' }}">
                        <!-- Image -->
                        <div class="h-40 w-full mb-4 relative rounded-2xl overflow-hidden bg-gray-100 dark:bg-slate-700 flex items-center justify-center">
                            @if($menu->image)
                                <img src="{{ asset('storage/' . $menu->image) }}" class="w-full h-full object-cover" alt="{{ $menu->name }}">
                            @else
                                <span class="text-4xl">🍽️</span>
                            @endif
                            @if($menu->is_best_seller)
                                <span class="absolute top-2 left-2 bg-yellow-400 text-yellow-900 text-[10px] font-bold px-2 py-1 rounded-full shadow-sm">
                                    Bestseller
                                </span>
                            @endif
                        </div>
                        
                        <!-- Details -->
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800 dark:text-slate-200 text-sm leading-snug line-clamp-2 mb-1">{{ $menu->name }}</h3>
                            <div class="flex items-center justify-between mt-3">
                                <span class="font-bold text-emerald-600">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                                <span class="text-[10px] font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded text-right">
                                    {{ $menu->category->is_drink ? 'Drink' : 'Food' }}
                                </span>
                            </div>
                        </div>

                        <!-- Add Button -->
                        <div class="mt-4">
                            @if($inCart)
                                <div class="flex items-center justify-between bg-emerald-50 dark:bg-emerald-900/30 rounded-xl p-1 border border-emerald-100 dark:border-emerald-800">
                                    <button wire:click="updateQuantity({{ $menu->id }}, -1)" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white dark:bg-slate-700 text-emerald-600 dark:text-emerald-400 shadow-sm hover:bg-emerald-100 dark:hover:bg-slate-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                    </button>
                                    <span class="font-bold text-emerald-800 dark:text-emerald-300">{{ $inCart['quantity'] }}</span>
                                    <button wire:click="updateQuantity({{ $menu->id }}, 1)" class="w-8 h-8 flex items-center justify-center rounded-lg bg-emerald-600 text-white shadow-sm hover:bg-emerald-700 dark:hover:bg-emerald-500 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </button>
                                </div>
                            @else
                                <button wire:click="addToCart({{ $menu->id }})" class="w-full py-2.5 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 font-bold text-sm rounded-xl hover:bg-emerald-100 dark:hover:bg-emerald-900/50 transition-colors border border-transparent dark:border-emerald-800">
                                    Add to Dish
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Tables Bar (Bottom) - Only show when Dine-In -->
        @if($orderType === 'dine-in')
        <div class="absolute bottom-0 left-0 right-0 bg-emerald-600 dark:bg-emerald-800 backdrop-blur-md border-t border-emerald-500 dark:border-emerald-700 py-3 md:py-4 px-4 md:px-8 shrink-0 no-scrollbar overflow-x-auto shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.15)] z-10">
            <div class="flex items-center gap-3 md:gap-4 min-w-max">
                <span class="text-sm font-bold text-white mr-2 flex items-center gap-2">
                    <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Select Table:
                </span>
                @foreach($tables as $table)
                    @php
                        $isOccupied = $table->status === 'occupied';
                        $isSelected = $selectedTableId === $table->id;
                    @endphp
                    <button type="button"
                        @if($isOccupied && !$isSelected) onclick="confirm('Kosongkan meja T{{ $table->table_number }} ini?') || event.stopImmediatePropagation()" @endif
                        wire:click="handleTableClick({{ $table->id }})"
                        class="flex items-center gap-3 px-4 py-2 rounded-full border transition-all hover:scale-105 active:scale-95
                        {{ $isSelected ? 'border-emerald-500 ring-2 ring-emerald-200 dark:ring-emerald-900 bg-emerald-50 dark:bg-emerald-900/30' : ($isOccupied ? 'border-gray-200 dark:border-slate-700 bg-gray-100 dark:bg-slate-800/80 opacity-80 hover:opacity-100 hover:border-orange-300 dark:hover:border-orange-500 hover:bg-orange-50 dark:hover:bg-orange-900/30 cursor-pointer' : 'border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 hover:border-emerald-300 dark:hover:border-emerald-500 hover:bg-emerald-50/50 dark:hover:bg-slate-700/50') }}">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm shadow-sm
                            {{ $isSelected ? 'bg-emerald-500 text-white' : ($isOccupied ? 'bg-gray-300 dark:bg-slate-600 text-gray-600 dark:text-slate-400' : 'bg-yellow-400 text-yellow-900') }}">
                            T{{ $table->table_number }}
                        </div>
                        <div class="text-left">
                            <div class="text-xs font-bold text-gray-800 dark:text-slate-200">{{ $isOccupied && !$isSelected ? 'Occupied' : 'Table ' . $table->table_number }}</div>
                            <div class="text-[10px] text-gray-400 dark:text-slate-500">{{ $table->capacity }} seats</div>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>
        @else
        <!-- Takeaway Bar -->
        <div class="absolute bottom-0 left-0 right-0 bg-emerald-600 dark:bg-emerald-800 backdrop-blur-md border-t border-emerald-500 dark:border-emerald-700 py-3 md:py-4 px-4 md:px-8 shrink-0 flex items-center shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.15)] z-10">
            <div class="flex items-center gap-3 text-emerald-900 dark:text-emerald-100 bg-white/90 dark:bg-slate-900/50 px-4 py-2 rounded-full border border-white/20 dark:border-emerald-900">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                <span class="font-bold text-sm">Takeaway Mode Active - No Table Required</span>
            </div>
        </div>
        @endif
        @endif

        @if($activeTab === 'tables')
        <div class="flex-1 w-full h-full bg-[#F4F7F6] dark:bg-slate-900 flex flex-col overflow-y-auto no-scrollbar">
            <!-- Top: Interactive Table Map -->
            <div class="w-full p-6 md:p-8 shrink-0">
                <h2 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-slate-200 mb-6 flex items-center gap-3">
                    <svg class="w-6 h-6 md:w-7 md:h-7 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Table Status Map
                </h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 md:gap-6 pb-6">
                    @foreach($tables as $table)
                        @php
                            $isOccupied = $table->status === 'occupied';
                        @endphp
                        <div 
                            @if($isOccupied) onclick="confirm('Kosongkan meja T{{ $table->table_number }} ini?') || event.stopImmediatePropagation()" @endif
                            wire:click="handleTableClick({{ $table->id }})"
                            class="bg-white dark:bg-slate-800 rounded-2xl md:rounded-3xl p-4 md:p-6 shadow-sm border border-gray-100 dark:border-slate-700 flex flex-col items-center justify-center transition-all hover:shadow-md cursor-pointer {{ $isOccupied ? 'border-red-200 dark:border-red-900 ring-2 ring-red-100 dark:ring-red-900/50 bg-red-50/30 dark:bg-red-900/10 hover:bg-red-100/50 dark:hover:bg-red-900/30' : 'hover:border-emerald-300 dark:hover:border-emerald-600' }}">
                            <div class="w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center font-bold text-2xl md:text-3xl mb-3 md:mb-4 shadow-sm shrink-0 {{ $isOccupied ? 'bg-red-500 text-white shadow-red-200' : 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-600 dark:text-emerald-400' }}">
                                T{{ $table->table_number }}
                            </div>
                            <h3 class="font-bold text-base md:text-lg text-gray-800 dark:text-slate-200 mb-1 text-center truncate w-full">{{ $isOccupied ? 'Occupied' : 'Available' }}</h3>
                            <p class="text-xs md:text-sm font-medium text-gray-400 dark:text-slate-500">{{ $table->capacity }} Seats</p>
                            @if($isOccupied)
                                <div class="mt-4 md:mt-5 px-3 md:px-4 py-1.5 bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-400 text-[10px] md:text-xs font-black uppercase tracking-wider rounded-full flex items-center justify-center gap-2 w-full max-w-[100px]">
                                    <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse shrink-0"></span>
                                    In Use
                                </div>
                            @else
                                <div class="mt-4 md:mt-5 px-3 md:px-4 py-1.5 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 text-[10px] md:text-xs font-black uppercase tracking-wider rounded-full flex items-center justify-center gap-2 w-full max-w-[100px]">
                                    <span class="w-2 h-2 rounded-full bg-emerald-400 shrink-0"></span>
                                    Ready
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
    
            <!-- Bottom: Dashboard/Payments List -->
            <div class="w-full shrink-0 border-t border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 relative z-10 shadow-2xl min-h-[500px] flex-1">
                @livewire('cashier.pos-dashboard')
            </div>
        </div>
        @endif
    </div>

    @if($activeTab === 'menu')
    <!-- Centered Cart & Checkout Modal -->
    <div class="fixed inset-0 z-40 flex items-center justify-center p-4 sm:p-6 transition-all duration-300 {{ $showCheckout ? 'opacity-100 visible' : 'opacity-0 invisible pointer-events-none' }}">
        
        <!-- Backdrop -->
        <div wire:click="closeCheckout" class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity duration-300 {{ $showCheckout ? 'opacity-100' : 'opacity-0' }}"></div>
        
        <!-- Modal Content -->
        <div class="bg-white dark:bg-slate-800 shadow-2xl rounded-3xl w-full max-w-md max-h-[95vh] overflow-hidden flex flex-col relative transform transition-all duration-300 ease-in-out z-50 {{ $showCheckout ? 'scale-100 translate-y-0' : 'scale-95 translate-y-4' }}">
            <div class="px-6 py-4 md:py-5 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between shrink-0">
                <h2 class="text-lg font-bold text-gray-800 dark:text-slate-200">Current Order</h2>
                <button wire:click="closeCheckout" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors bg-gray-100 dark:bg-slate-700 w-8 h-8 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6 pb-2">
                @if($errors->has('table'))
                    <div class="mb-4 px-4 py-2 bg-red-50 text-red-600 rounded-lg text-sm font-medium border border-red-100 flex items-center gap-2">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        {{ $errors->first('table') }}
                    </div>
                @endif
                
                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-500 dark:text-slate-400 uppercase mb-2">
                        Customer Name <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="customerName" 
                        placeholder="Masukkan nama pelanggan..." 
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-gray-800 dark:text-slate-200 placeholder-gray-400 dark:placeholder-slate-500 transition-colors
                        {{ ($paymentError && str_contains($paymentError, 'Nama')) ? 'border-red-400 bg-red-50 dark:bg-red-900/20' : 'border-gray-200 dark:border-slate-600' }}"
                    >
                    @if($paymentError && str_contains($paymentError, 'Nama'))
                        <p class="mt-1 text-xs text-red-500 font-medium flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $paymentError }}
                        </p>
                    @endif
                </div>
            </div>

            <!-- Cart Items -->
            <div class="flex-1 overflow-y-auto px-6 py-2 space-y-4 no-scrollbar">
                @if(empty($cart))
                    <div class="h-full flex flex-col items-center justify-center text-gray-400 dark:text-slate-500">
                        <svg class="w-16 h-16 mb-4 text-gray-200 dark:text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <p class="text-sm font-medium">Cart is empty</p>
                    </div>
                @endif
                @foreach($cart as $item)
                    <div class="flex gap-3 items-center">
                        <div class="w-12 h-12 rounded-lg bg-gray-100 dark:bg-slate-700 shrink-0 overflow-hidden">
                            @if($item['image'])
                                <img src="{{ $item['image'] }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-lg">🍽️</div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-sm text-gray-800 truncate">{{ $item['name'] }}</h4>
                            <div class="text-emerald-600 font-bold text-xs mt-0.5">Rp {{ number_format($item['price'], 0, ',', '.') }}</div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-gray-600">x{{ $item['quantity'] }}</span>
                            <button wire:click="removeCartItem({{ $item['id'] }})" class="w-6 h-6 rounded bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-100">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Totals & Payment -->
            <div class="px-6 py-6 bg-gray-50 dark:bg-slate-700/50 border-t border-gray-100 dark:border-slate-600 rounded-t-3xl mt-auto">
                <div class="space-y-2 mb-6">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-slate-400 font-medium">Subtotal</span>
                        <span class="text-gray-800 dark:text-slate-200 font-bold">Rp {{ number_format($this->subtotal, 0, ',', '.') }}</span>
                    </div>
                    @if($this->discountAmount > 0)
                    <div class="flex justify-between text-sm text-green-600 dark:text-green-400 font-medium">
                        <span>Discount ({{ $appliedDiscount['code'] }})</span>
                        <span>- Rp {{ number_format($this->discountAmount, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    @if($this->serviceChargeAmount > 0)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-slate-400 font-medium">Service Charge</span>
                        <span class="text-gray-800 dark:text-slate-200 font-bold">Rp {{ number_format($this->serviceChargeAmount, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    @if($this->taxAmount > 0)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-slate-400 font-medium">Tax</span>
                        <span class="text-gray-800 dark:text-slate-200 font-bold">Rp {{ number_format($this->taxAmount, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between text-lg pt-2 border-t border-gray-200 dark:border-slate-600 mt-2">
                        <span class="text-gray-800 dark:text-slate-200 font-bold">Total</span>
                        <span class="text-emerald-600 dark:text-emerald-400 font-extrabold">Rp {{ number_format($this->total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Discount Code Input -->
                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-500 dark:text-slate-400 uppercase mb-2">Discount Code</label>
                    <div class="flex gap-2">
                        <input type="text" wire:model.live.debounce.300ms="discountCode" placeholder="PROMO123" class="flex-1 px-4 py-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-xl text-sm font-bold text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none uppercase" @if($appliedDiscount) disabled @endif>
                        @if($appliedDiscount)
                            <button type="button" wire:click="removeDiscount" class="px-4 py-2 bg-red-50 text-red-500 rounded-xl text-sm font-bold border border-red-200 hover:bg-red-100 transition-colors">
                                Reset
                            </button>
                        @else
                            <button type="button" wire:click="applyDiscount" class="px-4 py-2 bg-emerald-50 text-emerald-700 rounded-xl text-sm font-bold border border-emerald-200 hover:bg-emerald-100 transition-colors">
                                Apply
                            </button>
                        @endif
                    </div>
                    @if($discountError)
                        <p class="text-xs text-red-500 font-medium mt-1.5">{{ $discountError }}</p>
                    @endif
                    @if($appliedDiscount)
                        <p class="text-xs text-green-600 dark:text-green-400 font-medium mt-1.5 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Diskon berhasil diterapkan!
                        </p>
                    @endif
                </div>

                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-500 dark:text-slate-400 uppercase mb-2">Payment Method</label>
                    <div class="grid grid-cols-2 gap-2">
                        <button wire:click="$set('paymentMethod', 'cash')" class="py-2.5 rounded-xl text-sm font-bold transition-colors border {{ $paymentMethod === 'cash' ? 'bg-emerald-100 dark:bg-emerald-900/50 border-emerald-500 text-emerald-800 dark:text-emerald-400' : 'bg-white dark:bg-slate-800 border-gray-200 dark:border-slate-600 text-gray-600 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-700' }}">
                            Cash
                        </button>
                        <button wire:click="$set('paymentMethod', 'qris')" class="py-2.5 rounded-xl text-sm font-bold transition-colors border {{ $paymentMethod === 'qris' ? 'bg-emerald-100 dark:bg-emerald-900/50 border-emerald-500 text-emerald-800 dark:text-emerald-400' : 'bg-white dark:bg-slate-800 border-gray-200 dark:border-slate-600 text-gray-600 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-700' }}">
                            QR Code
                        </button>
                    </div>
                </div>

                @if($paymentMethod === 'cash')
                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-500 dark:text-slate-400 uppercase mb-2">Amount Given</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold text-sm">Rp</span>
                        <input type="number" wire:model.live.debounce.300ms="amountGiven" placeholder="0" class="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-xl text-sm font-bold text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none placeholder-gray-300 dark:placeholder-slate-500">
                    </div>
                    @if($paymentError)
                        <p class="text-xs text-red-500 font-medium mt-1.5">{{ $paymentError }}</p>
                    @endif
                    @if($amountGiven && $amountGiven >= $this->total)
                        <div class="flex justify-between items-center mt-2 px-3 py-2 bg-emerald-50 dark:bg-emerald-900/30 rounded-lg">
                            <span class="text-xs font-bold text-emerald-600 dark:text-emerald-500 uppercase">Change</span>
                            <span class="text-sm font-extrabold text-emerald-700 dark:text-emerald-400">Rp {{ number_format($amountGiven - $this->total, 0, ',', '.') }}</span>
                        </div>
                    @endif
                </div>
                @endif

                <button wire:click="processOrder" class="w-full py-4 bg-emerald-600 text-white rounded-2xl font-bold shadow-lg shadow-emerald-200 hover:bg-emerald-700 hover:-translate-y-0.5 transition-all focus:ring-4 focus:ring-emerald-100">
                    Process Payment
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Payment Success Modal -->
    @if($showSuccess && $completedOrder)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/40 backdrop-blur-sm">
            <div class="bg-white rounded-[2rem] p-8 max-w-sm w-full shadow-2xl transform transition-all text-center relative overflow-hidden">
                <!-- Decorative background elements -->
                <div class="absolute top-0 left-0 right-0 h-32 bg-gradient-to-b from-emerald-50 to-white"></div>
                
                <div class="relative z-10">
                    <!-- Big checkmark -->
                    <div class="w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <div class="w-16 h-16 bg-emerald-500 rounded-full flex items-center justify-center shadow-lg shadow-emerald-200">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    </div>
                    
                    <h2 class="text-2xl font-extrabold text-gray-900 mb-1">Payment Success!</h2>
                    <div class="text-3xl font-black text-emerald-600 mb-4">Rp {{ number_format($completedOrder->total_price, 0, ',', '.') }}</div>

                    {{-- Queue Number Badge --}}
                    @if($completedOrder->queue_number)
                    <div class="mb-6 mx-auto">
                        <div class="inline-flex flex-col items-center px-8 py-4 rounded-2xl border-2 {{ $completedOrder->queue_type === 1 ? 'bg-blue-50 border-blue-300' : 'bg-purple-50 border-purple-300' }}">
                            <span class="text-xs font-bold uppercase tracking-widest {{ $completedOrder->queue_type === 1 ? 'text-blue-500' : 'text-purple-500' }} mb-1">
                                {{ $completedOrder->queue_type === 1 ? '🪙 Antrian Cash' : '📱 Antrian QRIS' }}
                            </span>
                            <span class="text-6xl font-black {{ $completedOrder->queue_type === 1 ? 'text-blue-700' : 'text-purple-700' }}">
                                {{ str_pad($completedOrder->queue_number, 3, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>
                    </div>
                    @endif
                    
                    <div class="space-y-3 text-sm mb-8 px-4">
                        <div class="flex justify-between">
                            <span class="text-gray-500 font-medium">Order ID</span>
                            <span class="text-gray-800 font-bold">{{ $completedOrder->order_number }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 font-medium">Payment Method</span>
                            <span class="text-gray-800 font-bold capitalize">{{ $completedOrder->payment_method === 'qris' ? 'QR Code' : $completedOrder->payment_method }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 font-medium">Payment Time</span>
                            <span class="text-gray-800 font-bold">{{ $completedOrder->created_at->format('d/m/Y h:i A') }}</span>
                        </div>
                    </div>
                    
                    <button wire:click="closeSuccess" class="w-full py-3.5 bg-emerald-600 text-white rounded-xl font-bold shadow-md hover:bg-emerald-700 transition-colors mb-4">
                        New Order
                    </button>
                    
                    <a href="{{ route('cashier.receipt', $completedOrder->id) }}" target="_blank" class="flex items-center justify-center gap-2 text-gray-500 hover:text-emerald-600 font-bold transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Print Receipt
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
