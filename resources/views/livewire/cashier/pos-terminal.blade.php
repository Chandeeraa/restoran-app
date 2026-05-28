<div x-data="{ sidebarOpen: window.innerWidth >= 1024 }" class="flex h-screen bg-[#FBF9F1] dark:bg-slate-900 w-full overflow-hidden transition-colors duration-300 relative">
    
    <!-- Memphis Dot Pattern Backdrop (Senada dengan PosScreen.kt) -->
    <div class="absolute inset-0 pointer-events-none opacity-20 z-0 bg-[radial-gradient(#D7C3AE_1.5px,transparent_1.5px)] [background-size:24px_24px]"></div>

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

    <!-- Left Sidebar (Branded to YON RESTO) -->
    <div
        x-show="sidebarOpen"
        x-transition:enter="transition ease-in-out duration-300 transform"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in-out duration-300 transform"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="fixed lg:relative z-30 lg:z-auto w-64 bg-white dark:bg-slate-800 shadow-sm flex flex-col justify-between shrink-0 h-full border-r border-gray-100 dark:border-slate-700 transition-colors duration-300 relative"
        x-cloak
    >
        <!-- Sidebar Blobs decoration -->
        <div class="absolute -top-12 -left-12 w-32 h-32 bg-brand-orange/5 rounded-full blur-2xl pointer-events-none"></div>

        <div class="p-6 relative z-10">
            <!-- Logo -->
            <div class="flex items-center gap-3 mb-10">
                <div class="w-10 h-10 bg-brand-orange/10 dark:bg-brand-orange/20 rounded-full flex items-center justify-center text-brand-orange font-bold text-xl drop-shadow-sm">
                    <i class="fa-solid fa-mug-hot"></i>
                </div>
                <span class="font-sans font-black text-lg text-brand-orange tracking-wider">YON RESTO</span>
            </div>

            <!-- Nav Links -->
            <nav class="space-y-2">
                <button @click="if(window.innerWidth < 1024) sidebarOpen = false" wire:click="setTab('menu')" class="w-full flex items-center gap-3 px-4 py-3 {{ $activeTab === 'menu' ? 'bg-brand-orange text-white shadow-lg shadow-brand-orange/20' : 'text-gray-600 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700/50' }} rounded-2xl font-bold transition-all active:scale-95">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    Menu
                </button>
                <button @click="if(window.innerWidth < 1024) sidebarOpen = false" wire:click="setTab('tables')" class="w-full flex items-center gap-3 px-4 py-3 {{ $activeTab === 'tables' ? 'bg-brand-orange text-white shadow-lg shadow-brand-orange/20' : 'text-gray-600 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700/50' }} rounded-2xl font-bold transition-all active:scale-95">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Table Services
                </button>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-gray-600 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700/50 rounded-2xl font-bold transition-all hover:text-brand-orange">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Back to Dashboard
                </a>
            </nav>
        </div>

        <div class="p-6 border-t border-gray-100 dark:border-slate-700 relative z-10">
            <!-- User Profiles -->
            <div class="space-y-3 mb-6">
                <div class="flex items-center gap-3 px-3 py-2 border border-gray-150 dark:border-slate-700 rounded-full cursor-pointer hover:bg-gray-50 dark:hover:bg-slate-700/50 shadow-sm bg-white dark:bg-slate-800">
                    <div class="w-8 h-8 rounded-full bg-brand-orange/15 text-brand-orange flex items-center justify-center font-black">
                        {{ substr(auth()->user()->name, 0, 2) }}
                    </div>
                    <span class="text-sm font-bold text-gray-700 dark:text-slate-300 truncate">{{ auth()->user()->name }}</span>
                </div>
            </div>
            
            <button wire:click="logout" class="flex items-center gap-3 text-gray-500 dark:text-slate-400 hover:text-red-600 dark:hover:text-red-400 font-bold transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Logout
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-full overflow-hidden relative min-w-0 z-10">
        <!-- Header -->
        <header class="h-16 md:h-20 flex items-center px-4 md:px-8 shrink-0 gap-3">
            <!-- Sidebar Toggle Button -->
            <button
                @click="sidebarOpen = !sidebarOpen"
                class="p-2.5 bg-white dark:bg-slate-800 rounded-full shadow-sm text-gray-500 dark:text-slate-400 hover:text-brand-orange dark:hover:text-brand-orange transition-colors border border-gray-100 dark:border-slate-700 shrink-0"
                :title="sidebarOpen ? 'Tutup menu' : 'Buka menu'"
            >
                <svg x-show="!sidebarOpen" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                <svg x-show="sidebarOpen" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <!-- Search Field -->
            <div class="flex items-center flex-1 max-w-2xl relative mr-2">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-slate-500 hidden md:block">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari hidangan untuk kasir..." class="w-full pl-4 md:pl-12 pr-4 py-2 md:py-3.5 bg-white dark:bg-slate-800 border-none rounded-full shadow-sm focus:ring-2 focus:ring-brand-orange outline-none text-sm font-bold text-gray-700 dark:text-slate-200 placeholder-gray-400 dark:placeholder-slate-500 transition-colors">
            </div>

            <!-- Toggles (Right) -->
            <div class="ml-auto flex items-center gap-2 md:gap-4 shrink-0">
                <!-- Dark Mode Toggle -->
                <button @click="darkMode = !darkMode" class="p-2 md:p-3 bg-white dark:bg-slate-800 rounded-full shadow-sm text-gray-500 dark:text-slate-400 hover:text-brand-orange dark:hover:text-brand-orange transition-colors border border-gray-100 dark:border-slate-700">
                    <svg x-show="!darkMode" class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    <svg x-show="darkMode" x-cloak class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </button>

                @if($activeTab === 'menu')
                <!-- Order Type Toggle -->
                <div class="flex bg-white dark:bg-slate-800 rounded-full p-1 shadow-sm border border-gray-100 dark:border-slate-700 hidden sm:flex">
                    <button wire:click="$set('orderType', 'dine-in')" class="px-3 md:px-5 py-1.5 md:py-2 rounded-full text-xs md:text-sm font-black transition-colors {{ $orderType === 'dine-in' ? 'bg-brand-orange/15 text-brand-orange' : 'text-gray-500 dark:text-slate-400 hover:bg-gray-50' }}">
                        Dine-In
                    </button>
                    <button wire:click="$set('orderType', 'takeaway')" class="px-3 md:px-5 py-1.5 md:py-2 rounded-full text-xs md:text-sm font-black transition-colors {{ $orderType === 'takeaway' ? 'bg-brand-orange/15 text-brand-orange' : 'text-gray-500 hover:bg-gray-50' }}">
                        Takeaway
                    </button>
                </div>
                <!-- Mobile Order Type Toggle -->
                <button wire:click="$set('orderType', '{{ $orderType === 'dine-in' ? 'takeaway' : 'dine-in' }}')" class="sm:hidden px-3 py-2 bg-brand-orange/15 text-brand-orange rounded-full text-xs font-black shadow-sm">
                    {{ $orderType === 'dine-in' ? 'Dine-In' : 'Takeaway' }}
                </button>
                
                <!-- Open Checkout Drawer Button -->
                <button wire:click="openCheckout" class="relative p-2.5 md:p-3 bg-white dark:bg-slate-800 rounded-full shadow-sm text-gray-600 dark:text-slate-300 hover:text-brand-orange border border-gray-100 dark:border-slate-700 transition-colors">
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    @if(count($cart) > 0)
                        <span class="absolute top-0 right-0 w-4 h-4 md:w-5 md:h-5 bg-brand-orange text-white text-[9px] md:text-xs font-black rounded-full flex items-center justify-center transform translate-x-1 -translate-y-1 shadow-sm">{{ array_sum(array_column($cart, 'quantity')) }}</span>
                    @endif
                </button>
                @else
                <!-- Dashboard Info pill -->
                <div class="flex items-center gap-2 bg-white dark:bg-slate-800 rounded-full px-4 py-2 shadow-sm border border-gray-100 dark:border-slate-700">
                    <div class="w-2 h-2 rounded-full bg-brand-orange animate-pulse"></div>
                    <span class="text-sm font-black text-brand-orange uppercase tracking-wider text-[11px]">Live Services</span>
                </div>
                @endif
            </div>
        </header>

        @if($activeTab === 'menu')

        <!-- Categories -->
        <div class="px-4 md:px-8 mb-6 shrink-0 no-scrollbar overflow-x-auto">
            <div class="flex gap-3 md:gap-4 min-w-max pb-2">
                <button wire:click="setCategory(null)" class="flex flex-col items-center justify-center w-24 h-28 rounded-3xl transition-all shadow-sm border {{ is_null($activeCategoryId) ? 'bg-brand-orange/15 border-brand-orange text-brand-orange shadow-lg shadow-brand-orange/5' : 'bg-white dark:bg-slate-800 text-gray-500 dark:text-slate-400 border-transparent' }}">
                    <div class="mb-2">
                        <i class="fas fa-th-large text-3xl"></i>
                    </div>
                    <span class="font-black text-sm">Semua</span>
                    <span class="text-[10px] opacity-70 mt-1 font-bold">{{ \App\Models\Menu::count() }} item</span>
                </button>
                @foreach($categories as $category)
                    <button wire:click="setCategory({{ $category->id }})" class="flex flex-col items-center justify-center w-28 h-28 rounded-3xl transition-all shadow-sm border {{ $activeCategoryId == $category->id ? 'bg-brand-orange/15 border-brand-orange text-brand-orange shadow-lg shadow-brand-orange/5' : 'bg-white dark:bg-slate-800 text-gray-500 dark:text-slate-400 border-transparent hover:bg-gray-50 dark:hover:bg-slate-700/50' }}">
                        <div class="mb-2 text-brand-orange">
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
                        <span class="font-black text-sm text-gray-800 dark:text-slate-200">{{ $category->name }}</span>
                        <span class="text-[10px] text-gray-400 mt-1 font-bold">{{ $category->menus()->count() }} item</span>
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
                    <div class="bg-white dark:bg-slate-800 rounded-[32px] p-4 shadow-sm flex flex-col transition-all border {{ $inCart ? 'border-brand-orange border-2 shadow-lg shadow-brand-orange/5' : 'border-transparent dark:border-slate-700 hover:shadow-md' }} group">
                        <!-- Image -->
                        <div class="h-40 w-full mb-4 relative rounded-[20px] overflow-hidden bg-gray-100 dark:bg-slate-700 flex items-center justify-center">
                            @if($menu->image)
                                <img src="{{ asset('storage/' . $menu->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $menu->name }}">
                            @else
                                <span class="text-4xl">🍽️</span>
                            @endif
                            @if($menu->is_best_seller)
                                <span class="absolute top-2 left-2 bg-brand-yellow text-brand-orange text-[9px] font-black px-2 py-0.5 rounded-full shadow-sm uppercase tracking-wider">
                                    Bestseller
                                </span>
                            @endif
                        </div>
                        
                        <!-- Details -->
                        <div class="flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="font-extrabold text-gray-800 dark:text-slate-200 text-sm leading-snug line-clamp-1 mb-1">{{ $menu->name }}</h3>
                            </div>
                            <div class="flex items-center justify-between mt-3">
                                <span class="font-black text-brand-orange text-base">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                                <span class="text-[9px] font-black text-brand-orange bg-brand-orange/10 px-2 py-0.5 rounded uppercase tracking-wider">
                                    {{ $menu->category->is_drink ? 'Drink' : 'Food' }}
                                </span>
                            </div>
                        </div>

                        <!-- Add Button -->
                        <div class="mt-4 shrink-0">
                            @if($inCart)
                                <div class="flex items-center justify-between bg-brand-orange/10 rounded-2xl p-1 border border-brand-orange/20">
                                    <button wire:click="updateQuantity({{ $menu->id }}, -1)" class="w-8 h-8 flex items-center justify-center rounded-xl bg-white dark:bg-slate-700 text-brand-orange shadow-sm hover:bg-brand-orange/20 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"></path></svg>
                                    </button>
                                    <span class="font-black text-brand-orange">{{ $inCart['quantity'] }}</span>
                                    <button wire:click="updateQuantity({{ $menu->id }}, 1)" class="w-8 h-8 flex items-center justify-center rounded-xl bg-brand-orange text-white shadow-sm hover:bg-orange-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                                    </button>
                                </div>
                            @else
                                <button wire:click="addToCart({{ $menu->id }})" class="w-full py-2.5 bg-brand-orange/10 text-brand-orange font-extrabold text-xs rounded-xl hover:bg-brand-orange hover:text-white transition-all border border-brand-orange/20 uppercase tracking-wider">
                                    Tambah
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Tables Selection Bar (Bottom) - Only show when Dine-In (Branded to Brand Orange) -->
        @if($orderType === 'dine-in')
        <div class="absolute bottom-0 left-0 right-0 bg-brand-orange text-white py-3 md:py-4 px-4 md:px-8 shrink-0 no-scrollbar overflow-x-auto shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.15)] z-10">
            <div class="flex items-center gap-3 md:gap-4 min-w-max">
                <span class="text-xs font-black mr-2 flex items-center gap-2 uppercase tracking-widest text-white/90">
                    <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Pilih Meja:
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
                        {{ $isSelected ? 'border-brand-orange ring-2 ring-orange-200 dark:ring-orange-950 bg-white text-brand-orange' : ($isOccupied ? 'border-orange-500/20 bg-orange-700/30 text-white opacity-85 hover:opacity-100' : 'border-orange-400 bg-orange-500/40 text-white hover:bg-orange-450') }}">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-black text-sm shadow-sm
                            {{ $isSelected ? 'bg-brand-orange text-white' : ($isOccupied ? 'bg-orange-700 text-orange-200' : 'bg-brand-yellow text-brand-orange') }}">
                            T{{ $table->table_number }}
                        </div>
                        <div class="text-left">
                            <div class="text-xs font-black uppercase tracking-tight">{{ $isOccupied && !$isSelected ? 'Terisi' : 'Meja ' . $table->table_number }}</div>
                            <div class="text-[9px] text-white/80 font-bold">{{ $table->capacity }} kursi</div>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>
        @else
        <!-- Takeaway Bar -->
        <div class="absolute bottom-0 left-0 right-0 bg-brand-green text-white py-3 md:py-4 px-4 md:px-8 shrink-0 flex items-center shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.15)] z-10">
            <div class="flex items-center gap-3 bg-white/20 px-4 py-2 rounded-full border border-white/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                <span class="font-black text-xs uppercase tracking-widest">Mode Bawa Pulang (Takeaway) Aktif - Meja Tidak Diperlukan</span>
            </div>
        </div>
        @endif
        @endif

        @if($activeTab === 'tables')
        <div class="flex-1 w-full h-full bg-transparent flex flex-col overflow-y-auto no-scrollbar">
            <!-- Top: Interactive Table Map -->
            <div class="w-full p-6 md:p-8 shrink-0">
                <h2 class="text-xl md:text-2xl font-black text-brand-orange mb-6 flex items-center gap-3">
                    <svg class="w-6 h-6 md:w-7 md:h-7 text-brand-orange" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Peta Status Meja
                </h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 md:gap-6 pb-6">
                    @foreach($tables as $table)
                        @php
                            $isOccupied = $table->status === 'occupied';
                        @endphp
                        <div 
                            @if($isOccupied) onclick="confirm('Kosongkan meja T{{ $table->table_number }} ini?') || event.stopImmediatePropagation()" @endif
                            wire:click="handleTableClick({{ $table->id }})"
                            class="bg-white dark:bg-slate-800 rounded-[32px] p-4 md:p-6 shadow-sm border border-gray-150 dark:border-slate-700 flex flex-col items-center justify-center transition-all hover:shadow-md hover:scale-[1.02] cursor-pointer {{ $isOccupied ? 'border-red-200 dark:border-red-950 ring-2 ring-red-100 dark:ring-red-900/50 bg-red-50/10 dark:bg-red-900/10 hover:bg-red-100/20' : 'hover:border-brand-orange' }}">
                            <div class="w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center font-black text-2xl md:text-3xl mb-3 md:mb-4 shadow-sm shrink-0 {{ $isOccupied ? 'bg-red-500 text-white' : 'bg-brand-orange/10 dark:bg-brand-orange/20 text-brand-orange' }}">
                                T{{ $table->table_number }}
                            </div>
                            <h3 class="font-extrabold text-base text-gray-800 dark:text-slate-200 mb-1 text-center truncate w-full">{{ $isOccupied ? 'Terisi' : 'Kosong' }}</h3>
                            <p class="text-xs font-bold text-gray-400 dark:text-slate-500">{{ $table->capacity }} Kursi</p>
                            @if($isOccupied)
                                <div class="mt-4 md:mt-5 px-3 md:px-4 py-1.5 bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-400 text-[10px] font-black uppercase tracking-wider rounded-full flex items-center justify-center gap-2 w-full max-w-[100px]">
                                    <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse shrink-0"></span>
                                    In Use
                                </div>
                            @else
                                <div class="mt-4 md:mt-5 px-3 md:px-4 py-1.5 bg-brand-green/10 text-brand-green text-[10px] font-black uppercase tracking-wider rounded-full flex items-center justify-center gap-2 w-full max-w-[100px]">
                                    <span class="w-2 h-2 rounded-full bg-brand-green shrink-0"></span>
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
    <!-- Centered Cart & Checkout Modal (Branded with Outfit & Brand Orange) -->
    <div class="fixed inset-0 z-40 flex items-center justify-center p-4 sm:p-6 transition-all duration-300 {{ $showCheckout ? 'opacity-100 visible' : 'opacity-0 invisible pointer-events-none' }}">
        
        <!-- Backdrop -->
        <div wire:click="closeCheckout" class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity duration-300 {{ $showCheckout ? 'opacity-100' : 'opacity-0' }}"></div>
        
        <!-- Modal Content -->
        <div class="bg-white dark:bg-slate-800 shadow-2xl rounded-[32px] w-full max-w-md max-h-[95vh] overflow-hidden flex flex-col relative transform transition-all duration-300 ease-in-out z-50 {{ $showCheckout ? 'scale-100 translate-y-0' : 'scale-95 translate-y-4' }}">
            <div class="px-6 py-4 md:py-5 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between shrink-0 bg-gray-50/50 dark:bg-slate-800/50">
                <h2 class="text-base font-black text-brand-orange uppercase tracking-wider">Pesanan POS Aktif</h2>
                <button wire:click="closeCheckout" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors bg-gray-150 dark:bg-slate-700 w-8 h-8 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6 pb-2">
                @if($errors->has('table'))
                    <div class="mb-4 px-4 py-2 bg-brand-orange/10 text-brand-orange rounded-xl text-xs font-bold border border-brand-orange/20 flex items-center gap-2">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        {{ $errors->first('table') }}
                    </div>
                @endif
                
                <div class="mb-4">
                    <label class="block text-[10px] font-black text-gray-500 dark:text-slate-400 uppercase mb-2">
                        Nama Pelanggan <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="customerName" 
                        placeholder="Masukkan nama pelanggan..." 
                        class="w-full px-4 py-2.5 bg-gray-55 dark:bg-slate-700/50 border rounded-xl text-xs font-bold focus:ring-2 focus:ring-brand-orange focus:border-brand-orange outline-none text-gray-800 dark:text-slate-200 placeholder-gray-400 dark:placeholder-slate-500 transition-colors
                        {{ ($paymentError && str_contains($paymentError, 'Nama')) ? 'border-red-400 bg-red-50 dark:bg-red-900/20' : 'border-gray-200 dark:border-slate-600' }}"
                    >
                    @if($paymentError && str_contains($paymentError, 'Nama'))
                        <p class="mt-1 text-xs text-red-500 font-bold flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $paymentError }}
                        </p>
                    @endif
                </div>
            </div>

            <!-- Cart Items -->
            <div class="flex-1 overflow-y-auto px-6 py-2 space-y-4 no-scrollbar">
                @if(empty($cart))
                    <div class="h-full flex flex-col items-center justify-center text-gray-400 dark:text-slate-500 py-6">
                        <svg class="w-16 h-16 mb-4 text-gray-200 dark:text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <p class="text-xs font-bold uppercase tracking-wider">Tagihan Kosong</p>
                    </div>
                @endif
                @foreach($cart as $item)
                    <div class="flex gap-3 items-center">
                        <div class="w-12 h-12 rounded-xl bg-gray-100 dark:bg-slate-700 shrink-0 overflow-hidden flex items-center justify-center">
                            @if($item['image'])
                                <img src="{{ $item['image'] }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-lg">🍽️</div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-extrabold text-sm text-gray-800 dark:text-slate-200 truncate">{{ $item['name'] }}</h4>
                            <div class="text-brand-orange font-black text-xs mt-0.5">Rp {{ number_format($item['price'], 0, ',', '.') }}</div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-black text-gray-500">x{{ $item['quantity'] }}</span>
                            <button wire:click="removeCartItem({{ $item['id'] }})" class="w-7 h-7 rounded-lg bg-red-50 hover:bg-red-100 text-red-500 flex items-center justify-center shadow-sm transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Totals & Payment -->
            <div class="px-6 py-6 bg-gray-55 dark:bg-slate-750 border-t border-gray-100 dark:border-slate-700 rounded-t-3xl mt-auto shadow-[0_-4px_20px_rgba(0,0,0,0.03)]">
                <div class="space-y-1.5 mb-5">
                    <div class="flex justify-between text-xs font-semibold">
                        <span class="text-gray-550 dark:text-slate-400">Subtotal</span>
                        <span class="text-gray-800 dark:text-slate-200">Rp {{ number_format($this->subtotal, 0, ',', '.') }}</span>
                    </div>
                    @if($this->discountAmount > 0)
                    <div class="flex justify-between text-xs text-red-500 font-bold">
                        <span>Diskon ({{ $appliedDiscount['code'] }})</span>
                        <span>- Rp {{ number_format($this->discountAmount, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    @if($this->serviceChargeAmount > 0)
                    <div class="flex justify-between text-xs font-semibold text-gray-500 dark:text-slate-400">
                        <span>Service Charge (5%)</span>
                        <span>Rp {{ number_format($this->serviceChargeAmount, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    @if($this->taxAmount > 0)
                    <div class="flex justify-between text-xs font-semibold text-gray-500 dark:text-slate-400">
                        <span>Pajak (Tax 10%)</span>
                        <span>Rp {{ number_format($this->taxAmount, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between text-sm pt-2 border-t border-gray-150 dark:border-slate-700 mt-2 items-center">
                        <span class="text-gray-900 dark:text-slate-100 font-black">Total Tagihan</span>
                        <span class="text-brand-orange font-black text-base">Rp {{ number_format($this->total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Discount Code Input -->
                <div class="mb-4">
                    <label class="block text-[10px] font-black text-gray-500 dark:text-slate-400 uppercase mb-2">Kode Kupon / Diskon</label>
                    <div class="flex gap-2">
                        <input type="text" wire:model.live.debounce.300ms="discountCode" placeholder="Contoh: PROMOYON" class="flex-1 px-4 py-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-xl text-xs font-bold text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-brand-orange focus:border-brand-orange outline-none uppercase placeholder-gray-400" @if($appliedDiscount) disabled @endif>
                        @if($appliedDiscount)
                            <button type="button" wire:click="removeDiscount" class="px-4 py-2 bg-red-50 text-red-500 rounded-xl text-xs font-black border border-red-200 hover:bg-red-100 transition-colors uppercase">
                                Reset
                            </button>
                        @else
                            <button type="button" wire:click="applyDiscount" class="px-4 py-2 bg-brand-orange/10 text-brand-orange rounded-xl text-xs font-black border border-brand-orange/20 hover:bg-brand-orange hover:text-white transition-all uppercase active:scale-95">
                                Terapkan
                            </button>
                        @endif
                    </div>
                    @if($discountError)
                        <p class="text-[10px] text-red-500 font-bold mt-1.5">{{ $discountError }}</p>
                    @endif
                    @if($appliedDiscount)
                        <p class="text-[10px] text-brand-green font-bold mt-1.5 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Kupon berhasil diterapkan!
                        </p>
                    @endif
                </div>

                <!-- Payment Method -->
                <div class="mb-4">
                    <label class="block text-[10px] font-black text-gray-500 dark:text-slate-400 uppercase mb-2">Metode Pembayaran</label>
                    <div class="grid grid-cols-2 gap-2">
                        <button wire:click="$set('paymentMethod', 'cash')" class="py-2.5 rounded-xl text-xs font-bold transition-colors border {{ $paymentMethod === 'cash' ? 'bg-brand-orange/10 border-brand-orange text-brand-orange shadow-sm' : 'bg-white dark:bg-slate-800 border-gray-200 dark:border-slate-600 text-gray-600 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-700' }}">
                            Tunai (Cash)
                        </button>
                        <button wire:click="$set('paymentMethod', 'qris')" class="py-2.5 rounded-xl text-xs font-bold transition-colors border {{ $paymentMethod === 'qris' ? 'bg-brand-orange/10 border-brand-orange text-brand-orange shadow-sm' : 'bg-white dark:bg-slate-800 border-gray-200 dark:border-slate-600 text-gray-600 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-700' }}">
                            QRIS
                        </button>
                    </div>
                </div>

                @if($paymentMethod === 'cash')
                <div class="mb-6">
                    <label class="block text-[10px] font-black text-gray-500 dark:text-slate-400 uppercase mb-2">Jumlah Uang Diterima</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-black text-xs">Rp</span>
                        <input type="number" wire:model.live.debounce.300ms="amountGiven" placeholder="0" class="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-xl text-xs font-bold text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-brand-orange focus:border-brand-orange outline-none placeholder-gray-300 dark:placeholder-slate-500 font-sans">
                    </div>
                    @if($paymentError)
                        <p class="text-[10px] text-red-500 font-bold mt-1.5">{{ $paymentError }}</p>
                    @endif
                    @if($amountGiven && $amountGiven >= $this->total)
                        <div class="flex justify-between items-center mt-2 px-3 py-2 bg-brand-green/10 rounded-xl border border-brand-green/20">
                            <span class="text-[10px] font-black text-brand-green uppercase">Kembalian</span>
                            <span class="text-sm font-black text-brand-green">Rp {{ number_format($amountGiven - $this->total, 0, ',', '.') }}</span>
                        </div>
                    @endif
                </div>
                @endif

                <button wire:click="processOrder" class="w-full py-3.5 bg-brand-green hover:bg-green-600 text-white rounded-2xl font-bold shadow-lg shadow-brand-green/20 hover:-translate-y-0.5 active:scale-95 transition-all uppercase tracking-widest text-xs">
                    Selesaikan & Cetak Transaksi
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Payment Success Modal (Branded inside YON RESTO) -->
    @if($showSuccess && $completedOrder)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm">
            <div class="bg-white rounded-[2rem] p-8 max-w-sm w-full shadow-2xl transform transition-all text-center relative overflow-hidden">
                <!-- Decorative background elements -->
                <div class="absolute top-0 left-0 right-0 h-32 bg-gradient-to-b from-brand-orange/10 to-transparent"></div>
                
                <div class="relative z-10">
                    <!-- Big checkmark -->
                    <div class="w-20 h-20 bg-brand-orange/15 rounded-full flex items-center justify-center mx-auto mb-6">
                        <div class="w-14 h-14 bg-brand-orange rounded-full flex items-center justify-center shadow-lg shadow-brand-orange/20">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    </div>
                    
                    <h2 class="text-xl font-extrabold text-gray-900 mb-1">Transaksi Berhasil!</h2>
                    <div class="text-2xl font-black text-brand-orange mb-4">Rp {{ number_format($completedOrder->total_price, 0, ',', '.') }}</div>

                    {{-- Queue Number Badge --}}
                    @if($completedOrder->queue_number)
                    <div class="mb-6 mx-auto">
                        <div class="inline-flex flex-col items-center px-8 py-3 rounded-2xl border-2 {{ $completedOrder->queue_type === 1 ? 'bg-orange-50 border-brand-orange/30' : 'bg-green-50 border-brand-green/30' }}">
                            <span class="text-[9px] font-black uppercase tracking-widest {{ $completedOrder->queue_type === 1 ? 'text-brand-orange' : 'text-brand-green' }} mb-0.5">
                                {{ $completedOrder->queue_type === 1 ? '🪙 Antrean Kasir' : '📱 Antrean QRIS' }}
                            </span>
                            <span class="text-5xl font-black {{ $completedOrder->queue_type === 1 ? 'text-brand-orange' : 'text-brand-green' }}">
                                {{ str_pad($completedOrder->queue_number, 3, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>
                    </div>
                    @endif
                    
                    <div class="space-y-2 text-xs mb-8 px-4 font-sans text-left">
                        <div class="flex justify-between">
                            <span class="text-gray-500 font-medium">Order ID</span>
                            <span class="text-gray-800 font-bold">{{ $completedOrder->order_number }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 font-medium">Metode Bayar</span>
                            <span class="text-gray-800 font-bold uppercase">{{ $completedOrder->payment_method === 'qris' ? 'QR Code (QRIS)' : 'Tunai' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 font-medium">Waktu Transaksi</span>
                            <span class="text-gray-800 font-bold">{{ $completedOrder->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                    
                    <button wire:click="closeSuccess" class="w-full py-3.5 bg-brand-orange text-white rounded-xl font-bold text-xs uppercase tracking-wider shadow-md hover:bg-orange-500 transition-colors mb-4 active:scale-95">
                        Transaksi Baru
                    </button>
                    
                    <a href="{{ route('cashier.receipt', $completedOrder->id) }}" target="_blank" class="flex items-center justify-center gap-2 text-gray-500 hover:text-brand-orange font-bold transition-colors text-xs uppercase tracking-wider">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Cetak Struk POS
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
