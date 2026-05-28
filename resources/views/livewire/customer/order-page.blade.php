<div class="min-h-screen w-full relative p-4 md:p-8 overflow-hidden bg-brand-cream dark:bg-slate-900 transition-colors duration-300" x-data="{ showCart: @entangle('showCart') }">
    
    <!-- Memphis Dot Pattern Backdrop (Senada dengan CustomerScreen.kt) -->
    <div class="absolute inset-0 pointer-events-none opacity-25 z-0 bg-[radial-gradient(#D7C3AE_1.5px,transparent_1.5px)] [background-size:24px_24px]"></div>

    <!-- Organic style background blobs -->
    <div class="absolute -top-24 -right-24 w-80 h-80 bg-brand-orange/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-[45%] -left-24 w-96 h-96 bg-brand-yellow/5 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative z-10 max-w-7xl mx-auto">
        @if (session()->has('table_warning'))
            <div class="mb-6 max-w-xl">
                <div class="bg-brand-orange/10 border border-brand-orange/20 rounded-2xl p-4 flex items-start gap-3">
                    <svg class="h-5 w-5 text-brand-orange shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <p class="text-xs text-orange-600 dark:text-orange-300 font-medium leading-relaxed">{{ session('table_warning') }}</p>
                </div>
            </div>
        @endif

        {{-- Header Bar --}}
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-2">
                <svg class="w-8 h-8 text-brand-orange fill-current drop-shadow-sm" viewBox="0 0 24 24">
                    <path d="M12 .587l3.668 7.431 8.2 1.192-5.934 5.787 1.4 8.168L12 18.896l-7.334 3.857 1.4-8.168L.132 9.21l8.2-1.192z"/>
                </svg>
                <h1 class="text-2xl font-black text-brand-orange tracking-tight">YON RESTO</h1>
            </div>

            <div class="flex items-center gap-3">
                @if($orderType === 'dine-in' && $table_id)
                    @php $activeTable = $tables->firstWhere('id', $table_id); @endphp
                    <div class="px-4 py-1.5 bg-brand-orange/10 rounded-full border border-brand-orange/20">
                        <span class="text-xs font-black text-brand-orange">Meja {{ $activeTable ? $activeTable->table_number : '' }}</span>
                    </div>
                @elseif($orderType === 'takeaway')
                    <div class="px-4 py-1.5 bg-brand-green/10 rounded-full border border-brand-green/20">
                        <span class="text-xs font-black text-brand-green">Bawa Pulang</span>
                    </div>
                @endif

                <button @click="showCart = true" class="relative p-2.5 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-750 text-gray-600 dark:text-slate-300 rounded-[18px] transition-all shadow-sm flex items-center justify-center active:scale-95">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    @if(count($cart) > 0)
                        <span class="absolute -top-1.5 -right-1.5 bg-brand-orange text-white text-[9px] font-black w-5 h-5 rounded-full flex items-center justify-center border-2 border-white dark:border-slate-900 shadow-sm">{{ array_sum(array_column($cart, 'quantity')) }}</span>
                    @endif
                </button>
            </div>
        </div>

        <!-- Banner Section (Senada dengan CustomerScreen.kt) -->
        <div class="relative w-full h-[190px] bg-gradient-to-r from-brand-orange to-orange-500 text-white rounded-[32px] overflow-hidden p-6 md:p-8 flex items-center mb-8 shadow-xl shadow-brand-orange/20">
            <!-- Background circles -->
            <div class="absolute -top-12 -right-12 w-32 h-32 bg-brand-yellow/30 rounded-full blur-lg"></div>
            <div class="absolute -bottom-16 -left-16 w-36 h-36 bg-white/10 rounded-full"></div>

            <div class="relative z-10 flex-1 flex items-center justify-between gap-4">
                <div class="max-w-[65%]">
                    <h2 class="text-lg md:text-2xl font-black leading-tight mb-2">Welcome to YON RESTO!</h2>
                    <p class="text-[10px] md:text-xs text-white/90 leading-normal max-w-sm font-medium">Bahan segar, cita rasa berani, diantarkan langsung ke hati Anda.</p>
                    <button @click="showCart = true" class="mt-4 px-4 py-2 bg-white text-brand-orange font-bold text-[10px] md:text-xs rounded-xl shadow-md hover:bg-orange-50 active:scale-95 transition-all">
                        Explore Deals
                    </button>
                </div>
                <!-- Banner Food Asset representation -->
                <div class="w-24 h-24 md:w-28 md:h-28 shrink-0 rounded-[24px] overflow-hidden shadow-2xl border-2 border-white/20">
                    <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuDu-q9u8MVuWYoSD1boEVM9-W2d3TdiECaCPSqhz0qpjQxelQy8mYWfKpOO4UcdFL-X8PyRg4KcVugJrzFs7mBD0V9MdkFlwIbG2VawGyLhFhx1qP5DVp_F-8HmzJrBYuUI9iW0jmEfNJU4CYK4hGFW9gAtkbFI98GxsTsP5L0n7LsXta_kJkS8up-yEuP5iHXHctOjDJdhwGJ-4vwrlOl3XKdtJWN9t3Gg3EAyprg1EYmY1VNtZGesfazlS9CbnBq8YUJhLWKmZy3d" class="w-full h-full object-cover" alt="Welcome Promo Food">
                </div>
            </div>
        </div>

        <!-- Search Bar Section -->
        <div class="mb-8 flex items-center gap-3">
            <div class="relative flex-1">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-slate-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari hidangan favorit Anda..." class="w-full pl-12 pr-4 py-3.5 bg-white dark:bg-slate-800 border-0 rounded-[18px] text-gray-900 dark:text-white text-sm placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-brand-orange outline-none transition-all shadow-sm">
            </div>
            <button class="p-3.5 bg-brand-orange hover:bg-orange-500 text-white rounded-[18px] transition-colors shadow-lg shadow-brand-orange/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
            </button>
        </div>

        <!-- Category Chips -->
        <div class="mb-8 overflow-x-auto no-scrollbar">
            <div class="flex gap-2 min-w-max pb-2">
                <button wire:click="setActiveCategory(null)" class="px-5 py-2.5 rounded-full font-bold text-sm transition-all border {{ is_null($activeCategoryId) ? 'bg-brand-orange text-white border-transparent shadow-lg shadow-brand-orange/20' : 'bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-300 border-gray-200 dark:border-slate-700 hover:bg-gray-50' }}">
                    Semua
                </button>
                @foreach($categories as $category)
                    <button wire:click="setActiveCategory({{ $category->id }})" class="px-5 py-2.5 rounded-full font-bold text-sm transition-all border {{ $activeCategoryId == $category->id ? 'bg-brand-orange text-white border-transparent shadow-lg shadow-brand-orange/20' : 'bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-300 border-gray-200 dark:border-slate-700 hover:bg-gray-50' }}">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Menu Recommendations Header -->
        <div class="mb-6 flex justify-between items-center">
            <h3 class="text-lg font-black text-gray-900 dark:text-white tracking-tight">Rekomendasi Koki</h3>
            <span class="text-xs font-semibold text-gray-400 dark:text-slate-500">{{ count($menus) }} hidangan ditemukan</span>
        </div>

        <!-- Menu Grid -->
        <main class="pb-28">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($menus as $menu)
                    @php
                        $inCart = collect($cart)->firstWhere('id', $menu->id);
                    @endphp
                    <div class="bg-white dark:bg-slate-800 rounded-[32px] overflow-hidden border border-gray-100 dark:border-slate-700 shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col group {{ $menu->isOutOfStock() ? 'opacity-50' : '' }}">
                        <!-- Image Container -->
                        <div class="h-48 w-full relative overflow-hidden bg-gray-50 dark:bg-slate-900 flex items-center justify-center shrink-0">
                            @if($menu->image)
                                <img src="{{ asset('storage/' . $menu->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $menu->name }}">
                            @else
                                <span class="text-5xl">🍽️</span>
                            @endif
                            
                            @if($menu->isOutOfStock())
                                <span class="absolute inset-0 bg-black/60 backdrop-blur-[2px] flex items-center justify-center text-white font-extrabold text-xs uppercase tracking-wider">Habis</span>
                            @else
                                @if($menu->is_best_seller)
                                    <span class="absolute top-4 left-4 bg-brand-yellow text-brand-orange text-[10px] font-black px-3 py-1 rounded-full shadow-md flex items-center gap-1 uppercase tracking-wider">
                                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.431 8.2 1.192-5.934 5.787 1.4 8.168L12 18.896l-7.334 3.857 1.4-8.168L.132 9.21l8.2-1.192z"/></svg>
                                        Best Seller
                                    </span>
                                @endif
                            @endif
                        </div>
                        
                        <!-- Details -->
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="font-extrabold text-gray-900 dark:text-white text-base leading-snug line-clamp-1 mb-1">{{ $menu->name }}</h3>
                                @if($menu->description)
                                    <p class="text-xs text-gray-400 dark:text-slate-400 line-clamp-2 leading-relaxed mb-4">{{ $menu->description }}</p>
                                @endif
                            </div>
                            
                            <div class="flex items-center justify-between mt-auto">
                                <span class="font-black text-brand-orange text-lg">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                                
                                @if($menu->isOutOfStock())
                                    <button disabled class="px-4 py-2 bg-gray-100 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-400 font-extrabold text-xs rounded-xl cursor-not-allowed">Habis</button>
                                @elseif($inCart)
                                    <div class="flex items-center bg-brand-orange/10 rounded-2xl p-1 border border-brand-orange/20">
                                        <button wire:click="decreaseQuantity({{ $menu->id }})" class="w-8 h-8 flex items-center justify-center rounded-xl bg-white dark:bg-slate-900 text-brand-orange hover:bg-brand-orange/20 transition-colors shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 12H6"></path></svg>
                                        </button>
                                        <span class="font-black text-brand-orange text-sm px-3">{{ $inCart['quantity'] }}</span>
                                        <button wire:click="increaseQuantity({{ $menu->id }})" class="w-8 h-8 flex items-center justify-center rounded-xl bg-brand-orange text-white hover:bg-orange-600 transition-colors shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9"></path></svg>
                                        </button>
                                    </div>
                                @else
                                    <button wire:click="addToCart({{ $menu->id }})" class="w-12 h-12 flex items-center justify-center bg-brand-orange hover:bg-orange-500 text-white rounded-2xl transition-all shadow-lg shadow-brand-orange/20 hover:scale-105">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-gray-500 dark:text-slate-400 text-sm bg-white dark:bg-slate-800 rounded-3xl border border-gray-150 dark:border-slate-700/50">
                        Menu tidak ditemukan.
                    </div>
                @endforelse
            </div>
        </main>

        <!-- Floating Bottom Cart Action Banner (Senada dengan CustomerScreen.kt) -->
        @if(count($cart) > 0)
            <div class="fixed bottom-6 left-1/2 -translate-x-1/2 w-[90%] max-w-md bg-brand-orange text-white p-4 rounded-3xl shadow-2xl flex items-center justify-between z-30 transition-all duration-300 hover:scale-[1.02] cursor-pointer"
                 @click="showCart = true">
                <div>
                    <span class="text-[9px] font-black text-white/70 uppercase tracking-widest block">KERANJANG BELANJA</span>
                    <span class="text-sm font-extrabold">{{ array_sum(array_column($cart, 'quantity')) }} Item ditambahkan</span>
                </div>
                <div class="flex items-center gap-2 text-brand-yellow font-black text-xs uppercase">
                    <span>Lihat Keranjang</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
            </div>
        @endif
    </div>

    <!-- Slide-over Cart & Checkout -->
    <div class="fixed inset-y-0 right-0 w-full sm:w-96 bg-brand-cream dark:bg-slate-900 shadow-[0_0_40px_rgba(0,0,0,0.1)] border-l border-gray-200 dark:border-slate-850 transform transition-transform duration-300 ease-in-out z-40 flex flex-col"
         :class="{'translate-x-0': showCart, 'translate-x-full': !showCart}">
        
        <div class="px-5 py-4 border-b border-gray-200 dark:border-slate-800 flex items-center justify-between bg-white/50 dark:bg-slate-800/50 backdrop-blur-md shrink-0">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Pesanan Anda</h2>
            <button @click="showCart = false" class="p-1.5 text-gray-500 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-full transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <!-- Cart Items -->
        <div class="flex-1 overflow-y-auto px-5 py-4 space-y-4 no-scrollbar">
            @if(empty($cart))
                <div class="h-full flex flex-col items-center justify-center text-gray-400 dark:text-slate-500 py-12">
                    <svg class="w-16 h-16 mb-4 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <p class="text-sm font-medium">Keranjang masih kosong</p>
                </div>
            @endif
            @foreach($cart as $menuId => $item)
                <div class="flex flex-col gap-2">
                    <div class="flex gap-3 items-center">
                        <div class="w-12 h-12 rounded-lg bg-gray-100 dark:bg-slate-800 shrink-0 overflow-hidden flex items-center justify-center border border-gray-200 dark:border-slate-700">
                            @if($item['image'])
                                <img src="{{ asset('storage/' . $item['id']) }}" class="hidden"> <!-- trick for binding -->
                                <img src="{{ $item['image'] }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-lg">🍽️</div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-sm text-gray-900 dark:text-white truncate">{{ $item['name'] }}</h4>
                            <div class="text-brand-orange font-bold text-xs mt-0.5">Rp {{ number_format($item['price'], 0, ',', '.') }}</div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-gray-500 dark:text-slate-400">x{{ $item['quantity'] }}</span>
                            <button wire:click="decreaseQuantity({{ $menuId }})" class="w-6 h-6 rounded bg-red-50 dark:bg-red-500/10 text-red-500 dark:text-red-400 flex items-center justify-center hover:bg-red-100 dark:hover:bg-red-500/20 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    </div>
                    <!-- Note input -->
                    <input type="text" wire:model.blur="cart.{{ $menuId }}.notes" placeholder="+ Tambah catatan (opsional)" class="text-[10px] w-full px-2 py-1.5 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 focus:border-brand-orange focus:ring-0 rounded-md text-gray-700 dark:text-slate-300">
                </div>
            @endforeach
        </div>

        <!-- Checkout Form & Totals -->
        @if(count($cart) > 0)
        <div class="bg-white dark:bg-slate-800 border-t border-gray-200 dark:border-slate-700 rounded-t-3xl shrink-0 shadow-[0_-4px_20px_rgba(0,0,0,0.05)]">
            <div class="px-5 pt-4 pb-2 space-y-3">
                <!-- Order Type Switcher -->
                <div class="mb-3">
                    <label class="block text-[10px] font-bold text-gray-500 dark:text-slate-400 uppercase mb-1.5">Tipe Pesanan</label>
                    <div class="grid grid-cols-2 gap-2 bg-gray-50 dark:bg-slate-900 p-1 rounded-xl border border-gray-200 dark:border-slate-700">
                        <button type="button" wire:click="$set('orderType', 'dine-in')" class="py-1.5 rounded-lg text-[11px] font-bold transition-colors flex items-center justify-center gap-1 {{ $orderType === 'dine-in' ? 'bg-brand-orange text-white shadow-sm' : 'text-gray-600 dark:text-slate-400' }}">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            Dine-In
                        </button>
                        <button type="button" wire:click="$set('orderType', 'takeaway')" class="py-1.5 rounded-lg text-[11px] font-bold transition-colors flex items-center justify-center gap-1 {{ $orderType === 'takeaway' ? 'bg-brand-orange text-white shadow-sm' : 'text-gray-600 dark:text-slate-400' }}">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            Takeaway
                        </button>
                    </div>
                </div>

                <!-- Customer Info -->
                <div class="grid {{ $orderType === 'dine-in' ? 'grid-cols-2' : 'grid-cols-1' }} gap-3">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 dark:text-slate-400 uppercase mb-1">Nama Pemesan</label>
                        <input type="text" wire:model="customer_name" placeholder="Nama..." class="w-full px-3 py-2 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-lg text-xs text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-orange focus:border-brand-orange outline-none transition-colors">
                        @error('customer_name') <span class="text-[10px] text-red-500 dark:text-red-400">{{ $message }}</span> @enderror
                    </div>
                    @if($orderType === 'dine-in')
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 dark:text-slate-400 uppercase mb-1">Pilih Meja</label>
                        <select wire:model="table_id" class="w-full px-3 py-2 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-lg text-xs text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-orange focus:border-brand-orange outline-none cursor-pointer transition-colors">
                            <option value="">Pilih...</option>
                            @foreach($tables as $t)
                                <option value="{{ $t->id }}">Meja {{ $t->table_number }}</option>
                            @endforeach
                        </select>
                        @error('table_id') <span class="text-[10px] text-red-500 dark:text-red-400">{{ $message }}</span> @enderror
                    </div>
                    @endif
                </div>

                <!-- Promo Code (Kupon Diskon - Menyelaraskan dengan desain.md) -->
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 dark:text-slate-400 uppercase mb-1">Kode Promo / Kupon</label>
                    @if($appliedDiscount)
                        <div class="flex items-center justify-between bg-brand-orange/10 border border-brand-orange/20 rounded-xl px-3 py-2">
                            <div>
                                <span class="text-xs font-black text-brand-orange uppercase">{{ $appliedDiscount['code'] }}</span>
                                <span class="text-[9px] text-gray-500 dark:text-slate-400 block mt-0.5">Telah diterapkan (Diskon Rp {{ number_format($this->discountAmount, 0, ',', '.') }})</span>
                            </div>
                            <button type="button" wire:click="removeDiscount" class="text-[10px] font-black text-red-500 hover:text-red-600 uppercase">Hapus</button>
                        </div>
                    @else
                        <div class="flex gap-2">
                            <input type="text" wire:model="discountCode" placeholder="Contoh: PROMOYON" class="flex-1 px-3 py-2 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-lg text-xs text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-orange focus:border-brand-orange outline-none transition-colors uppercase placeholder-gray-400">
                            <button type="button" wire:click="applyDiscount" class="px-4 py-2 bg-brand-orange hover:bg-orange-500 text-white rounded-lg text-xs font-bold transition-all active:scale-95">Terapkan</button>
                        </div>
                        @if($discountError)
                            <span class="text-[10px] text-red-500 dark:text-red-400 mt-1 block">{{ $discountError }}</span>
                        @endif
                    @endif
                </div>

                <!-- Payment Method -->
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 dark:text-slate-400 uppercase mb-1">Metode Pembayaran</label>
                    <div class="grid grid-cols-2 gap-2">
                        <button wire:click="$set('paymentMethod', 'cash')" class="py-2 rounded-lg text-xs font-bold transition-colors border {{ $paymentMethod === 'cash' ? 'bg-brand-orange border-brand-orange text-white shadow-lg shadow-brand-orange/20' : 'bg-gray-50 dark:bg-slate-900 border-gray-200 dark:border-slate-700 text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white' }}">
                            Tunai (Kasir)
                        </button>
                        <button wire:click="$set('paymentMethod', 'qris')" class="py-2 rounded-lg text-xs font-bold transition-colors border flex items-center justify-center gap-1 {{ $paymentMethod === 'qris' ? 'bg-brand-orange border-brand-orange text-white shadow-lg shadow-brand-orange/20' : 'bg-gray-50 dark:bg-slate-900 border-gray-200 dark:border-slate-700 text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white' }}">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                            QRIS
                        </button>
                    </div>
                </div>
            </div>

            <div class="px-5 py-4 border-t border-gray-100 dark:border-slate-700">
                <div class="space-y-1.5 mb-4">
                    <div class="flex justify-between text-xs">
                        <span class="text-gray-500 dark:text-slate-400">Subtotal</span>
                        <span class="font-bold text-gray-900 dark:text-white">Rp {{ number_format($this->cartTotal, 0, ',', '.') }}</span>
                    </div>
                    @if($this->discountAmount > 0)
                        <div class="flex justify-between text-xs text-red-500">
                            <span>Diskon</span>
                            <span class="font-bold">- Rp {{ number_format($this->discountAmount, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    @if($this->serviceChargeAmount > 0)
                        <div class="flex justify-between text-xs text-gray-500 dark:text-slate-400">
                            <span>Service Charge (5%)</span>
                            <span class="font-bold">Rp {{ number_format($this->serviceChargeAmount, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    @if($this->taxAmount > 0)
                        <div class="flex justify-between text-xs text-gray-500 dark:text-slate-400">
                            <span>Pajak (Tax 10%)</span>
                            <span class="font-bold">Rp {{ number_format($this->taxAmount, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between text-sm pt-2 mt-2 border-t border-gray-100 dark:border-slate-700">
                        <span class="font-bold text-gray-900 dark:text-white">Total</span>
                        <span class="font-extrabold text-brand-orange text-lg">Rp {{ number_format($this->grandTotal, 0, ',', '.') }}</span>
                    </div>
                </div>
                
                <button wire:click="checkout" wire:loading.attr="disabled" class="w-full py-3.5 bg-brand-orange hover:bg-orange-500 text-white rounded-xl font-bold shadow-lg shadow-brand-orange/30 transition-colors flex items-center justify-center gap-2">
                    <span wire:loading wire:target="checkout" class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                    @if($paymentMethod === 'qris')
                        Bayar via QRIS
                    @else
                        Pesan & Bayar di Kasir
                    @endif
                </button>
            </div>
        </div>
        @endif
    </div>

    <!-- Overlay for slide-over -->
    <div x-show="showCart" x-cloak @click="showCart = false" class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm z-20 transition-opacity"></div>

    <!-- QRIS Modal -->
    @if($showQrisModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm">
            <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-3xl p-6 max-w-xs w-full shadow-2xl text-center">
                <div class="mb-4">
                    <img src="{{ asset('img/qris.jpg') }}" alt="QRIS" class="w-full h-auto mx-auto p-2 border-2 border-gray-100 dark:border-slate-700 rounded-2xl bg-white shadow-inner object-contain max-h-64">
                </div>
                <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-1">Scan QRIS</h3>
                <p class="text-xs text-gray-500 dark:text-slate-400 mb-6">Silakan scan kode QR di atas dengan aplikasi m-banking atau e-wallet Anda.</p>
                
                <div class="bg-brand-orange/10 border border-brand-orange/20 rounded-xl p-3 mb-6">
                    <div class="text-[10px] text-brand-orange font-bold uppercase mb-1">Total Pembayaran</div>
                    <div class="text-xl font-extrabold text-brand-orange">Rp {{ number_format($this->grandTotal, 0, ',', '.') }}</div>
                </div>

                <div class="space-y-3">
                    <button wire:click="simulateQrisSuccess" class="w-full py-3 bg-brand-orange hover:bg-orange-500 text-white rounded-xl font-bold text-sm shadow-md transition-colors font-sans">
                        Simulasi Bayar Berhasil
                    </button>
                    <button wire:click="cancelQris" class="w-full py-3 bg-gray-100 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-600 dark:text-slate-300 rounded-xl font-bold text-sm hover:bg-gray-200 dark:hover:bg-slate-700 transition-colors">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Payment Success Modal -->
    @if($showSuccess && $completedOrder)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm">
            <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-[2rem] p-8 max-w-sm w-full shadow-2xl text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-32 bg-gradient-to-b from-brand-orange/10 to-transparent"></div>
                
                <div class="relative z-10">
                    <div class="w-20 h-20 bg-brand-orange/15 rounded-full flex items-center justify-center mx-auto mb-4">
                        <div class="w-14 h-14 bg-brand-orange rounded-full flex items-center justify-center shadow-lg shadow-brand-orange/20">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    </div>
                    
                    <h2 class="text-xl font-extrabold text-gray-900 dark:text-white mb-1">Pesanan Berhasil!</h2>
                    <p class="text-xs text-gray-500 dark:text-slate-400 mb-6">Pesanan Anda langsung masuk to antrean dapur.</p>
                    
                    <div class="bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl p-4 text-left space-y-2 text-xs mb-6 font-sans">
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-slate-400 font-medium">Order ID</span>
                            <span class="text-gray-900 dark:text-white font-bold">{{ $completedOrder->order_number }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-slate-400 font-medium">Pembayaran</span>
                            <span class="text-gray-900 dark:text-white font-bold uppercase">{{ $completedOrder->payment_method }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-slate-400 font-medium">Status</span>
                            <span class="text-brand-orange font-bold uppercase">{{ $completedOrder->payment_status }}</span>
                        </div>
                    </div>
                    
                    <button wire:click="closeSuccess" class="w-full py-3.5 bg-brand-orange hover:bg-orange-500 text-white rounded-xl font-bold text-sm shadow-md transition-colors">
                        Selesai & Lacak Pesanan
                    </button>
                </div>
            </div>
        </div>
    @endif
    
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        [x-cloak] { display: none !important; }
    </style>
</div>
