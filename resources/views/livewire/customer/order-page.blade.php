<div class="min-h-screen w-full relative p-4 md:p-8" x-data="{ showCart: @entangle('showCart') }">

    @if (session()->has('table_warning'))
        <div class="mb-6 max-w-xl">
            <div class="bg-orange-500/10 border border-orange-500/20 rounded-xl p-4 flex items-start gap-3">
                <svg class="h-5 w-5 text-orange-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <p class="text-xs text-orange-600 dark:text-orange-300 font-medium leading-relaxed">{{ session('table_warning') }}</p>
            </div>
        </div>
    @endif

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">Pesan Menu</h2>
            <p class="text-gray-500 dark:text-slate-400 text-sm">Pilih hidangan terlezat kami untuk Anda nikmati.</p>
        </div>
        <div>
            <button @click="showCart = true" class="relative px-5 py-2.5 bg-brand-green hover:bg-green-500 text-white rounded-xl font-bold text-sm shadow-lg shadow-brand-green/30 flex items-center gap-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Keranjang
                @if(count($cart) > 0)
                    <span class="bg-white text-brand-green text-[10px] font-bold px-1.5 py-0.5 rounded-full flex items-center justify-center">{{ array_sum(array_column($cart, 'quantity')) }}</span>
                @endif
            </button>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="mb-8 max-w-xl">
        <div class="relative">
            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-slate-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari makanan atau minuman..." class="w-full pl-12 pr-4 py-3 bg-white/80 dark:bg-slate-800/80 backdrop-blur-md border border-gray-200 dark:border-slate-700 rounded-xl text-gray-900 dark:text-white text-sm placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-brand-green outline-none transition-colors">
        </div>
    </div>

    <!-- Category Pills (Horizontal Scroll) -->
    <div class="mb-8 overflow-x-auto no-scrollbar">
        <div class="flex gap-3 min-w-max pb-2">
            <button wire:click="setActiveCategory(null)" class="flex flex-col items-center justify-center w-20 h-24 rounded-2xl transition-all {{ is_null($activeCategoryId) ? 'bg-brand-green text-white shadow-lg shadow-brand-green/30' : 'bg-white/80 dark:bg-slate-800/80 backdrop-blur-md text-gray-600 dark:text-slate-400 border border-gray-200 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700 hover:text-brand-orange dark:hover:text-brand-yellow' }}">
                <div class="mb-1 text-current">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                </div>
                <span class="font-bold text-xs">All</span>
                <span class="text-[9px] opacity-75 mt-0.5">{{ \App\Models\Menu::count() }} item</span>
            </button>
            @foreach($categories as $category)
                <button wire:click="setActiveCategory({{ $category->id }})" class="flex flex-col items-center justify-center w-20 h-24 rounded-2xl transition-all {{ $activeCategoryId == $category->id ? 'bg-brand-green text-white shadow-lg shadow-brand-green/30' : 'bg-white/80 dark:bg-slate-800/80 backdrop-blur-md text-gray-600 dark:text-slate-400 border border-gray-200 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700 hover:text-brand-orange dark:hover:text-brand-yellow' }}">
                    <div class="mb-1 text-current">
                        @if(strtolower($category->name) === 'dessert')
                            <i class="fas fa-cheese text-[22px] leading-none mb-0.5"></i>
                        @elseif(strtolower($category->name) === 'snack')
                            <i class="fas fa-hamburger text-[22px] leading-none mb-0.5"></i>
                        @elseif($category->is_drink)
                            <i class="bi bi-cup-straw text-2xl leading-none"></i>
                        @else
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 3v6" />
                                <path d="M10 3v6" />
                                <path d="M14 3v6" />
                                <path d="M6 9c0 2 8 2 8 0" />
                                <path d="M10 10.5V21" />
                                <path d="M19 3v9h-3c0-4 2-7 3-9z" />
                                <path d="M17.5 12V21" />
                            </svg>
                        @endif
                    </div>
                    <span class="font-bold text-xs text-center px-1 truncate w-full">{{ $category->name }}</span>
                    <span class="text-[9px] opacity-75 mt-0.5">{{ $category->menus()->count() }} item</span>
                </button>
            @endforeach
        </div>
    </div>

    <!-- Menu Grid -->
    <main class="pb-24">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-5">
            @forelse($menus as $menu)
                @php
                    $inCart = collect($cart)->firstWhere('id', $menu->id);
                @endphp
                <div class="bg-white/90 dark:bg-slate-800/90 backdrop-blur-sm rounded-2xl p-4 border transition-all flex flex-col {{ $inCart ? 'border-brand-green shadow-lg shadow-brand-green/10' : 'border-gray-200 dark:border-slate-700 hover:shadow-md' }} {{ $menu->isOutOfStock() ? 'opacity-50' : '' }}">
                    <!-- Image -->
                    <div class="h-32 w-full mb-3 relative rounded-xl overflow-hidden bg-gray-100 dark:bg-slate-900 flex items-center justify-center shrink-0">
                        @if($menu->image)
                            <img src="{{ asset('storage/' . $menu->image) }}" class="w-full h-full object-cover" alt="{{ $menu->name }}">
                        @else
                            <span class="text-3xl">🍽️</span>
                        @endif
                        
                        @if($menu->isOutOfStock())
                            <span class="absolute inset-0 bg-black/60 flex items-center justify-center text-white font-bold text-xs uppercase tracking-wider">Habis</span>
                        @else
                            @if($menu->is_best_seller)
                                <span class="absolute top-2 left-2 bg-brand-yellow text-yellow-900 text-[9px] font-bold px-1.5 py-0.5 rounded shadow-sm uppercase tracking-wider">
                                    Bestseller
                                </span>
                            @endif
                        @endif
                    </div>
                    
                    <!-- Details -->
                    <div class="flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-gray-900 dark:text-white text-xs sm:text-sm leading-snug line-clamp-2 mb-1">{{ $menu->name }}</h3>
                            @if($menu->description)
                                <p class="text-[10px] text-gray-500 dark:text-slate-400 line-clamp-2 mb-2 leading-normal">{{ $menu->description }}</p>
                            @endif
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <span class="font-extrabold text-brand-green dark:text-emerald-400 text-sm sm:text-base">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Add Button -->
                    <div class="mt-4 shrink-0">
                        @if($menu->isOutOfStock())
                            <button disabled class="w-full py-2.5 bg-gray-100 dark:bg-slate-900 text-gray-400 dark:text-slate-500 font-bold text-xs rounded-xl cursor-not-allowed border border-gray-200 dark:border-slate-700">Habis</button>
                        @elseif($inCart)
                            <div class="flex items-center justify-between bg-brand-green/10 rounded-xl p-1 border border-brand-green/20">
                                <button wire:click="decreaseQuantity({{ $menu->id }})" class="w-7 h-7 flex items-center justify-center rounded bg-white dark:bg-slate-900 text-brand-green hover:bg-brand-green/20 transition-colors shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"></path></svg>
                                </button>
                                <span class="font-bold text-brand-green text-xs">{{ $inCart['quantity'] }}</span>
                                <button wire:click="increaseQuantity({{ $menu->id }})" class="w-7 h-7 flex items-center justify-center rounded bg-brand-green text-white hover:bg-green-500 transition-colors shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                </button>
                            </div>
                        @else
                            <button wire:click="addToCart({{ $menu->id }})" class="w-full py-2 bg-brand-green/10 text-brand-green hover:bg-brand-green hover:text-white font-bold text-xs rounded-xl transition-all border border-brand-green/20">
                                Tambah
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-gray-500 dark:text-slate-400 text-sm">
                    Menu tidak ditemukan.
                </div>
            @endforelse
        </div>
    </main>

    <!-- Slide-over Cart & Checkout -->
    <div class="fixed inset-y-0 right-0 w-full sm:w-96 bg-brand-cream dark:bg-slate-900 shadow-[0_0_40px_rgba(0,0,0,0.1)] border-l border-gray-200 dark:border-slate-800 transform transition-transform duration-300 ease-in-out z-40 flex flex-col"
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
                                <img src="{{ $item['image'] }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-lg">🍽️</div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-sm text-gray-900 dark:text-white truncate">{{ $item['name'] }}</h4>
                            <div class="text-brand-green font-bold text-xs mt-0.5">Rp {{ number_format($item['price'], 0, ',', '.') }}</div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-gray-500 dark:text-slate-400">x{{ $item['quantity'] }}</span>
                            <button wire:click="decreaseQuantity({{ $menuId }})" class="w-6 h-6 rounded bg-red-50 dark:bg-red-500/10 text-red-500 dark:text-red-400 flex items-center justify-center hover:bg-red-100 dark:hover:bg-red-500/20 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    </div>
                    <!-- Note input -->
                    <input type="text" wire:model.blur="cart.{{ $menuId }}.notes" placeholder="+ Tambah catatan (opsional)" class="text-[10px] w-full px-2 py-1.5 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 focus:border-brand-green focus:ring-0 rounded-md text-gray-700 dark:text-slate-300">
                </div>
            @endforeach
        </div>

        <!-- Checkout Form & Totals -->
        @if(count($cart) > 0)
        <div class="bg-white dark:bg-slate-800 border-t border-gray-200 dark:border-slate-700 rounded-t-3xl shrink-0 shadow-[0_-4px_20px_rgba(0,0,0,0.05)]">
            <div class="px-5 pt-4 pb-2 space-y-3">
                <!-- Customer Info -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 dark:text-slate-400 uppercase mb-1">Nama Pemesan</label>
                        <input type="text" wire:model="customer_name" placeholder="Nama..." class="w-full px-3 py-2 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-lg text-xs text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-green focus:border-brand-green outline-none transition-colors">
                        @error('customer_name') <span class="text-[10px] text-red-500 dark:text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 dark:text-slate-400 uppercase mb-1">Pilih Meja</label>
                        <select wire:model="table_id" class="w-full px-3 py-2 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-lg text-xs text-gray-900 dark:text-white focus:ring-1 focus:ring-brand-green focus:border-brand-green outline-none cursor-pointer transition-colors">
                            <option value="">Pilih...</option>
                            @foreach($tables as $t)
                                <option value="{{ $t->id }}">Meja {{ $t->table_number }}</option>
                            @endforeach
                        </select>
                        @error('table_id') <span class="text-[10px] text-red-500 dark:text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Payment Method -->
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 dark:text-slate-400 uppercase mb-1">Metode Pembayaran</label>
                    <div class="grid grid-cols-2 gap-2">
                        <button wire:click="$set('paymentMethod', 'cash')" class="py-2 rounded-lg text-xs font-bold transition-colors border {{ $paymentMethod === 'cash' ? 'bg-brand-green border-brand-green text-white shadow-lg shadow-brand-green/20' : 'bg-gray-50 dark:bg-slate-900 border-gray-200 dark:border-slate-700 text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white' }}">
                            Tunai (Kasir)
                        </button>
                        <button wire:click="$set('paymentMethod', 'qris')" class="py-2 rounded-lg text-xs font-bold transition-colors border flex items-center justify-center gap-1 {{ $paymentMethod === 'qris' ? 'bg-brand-green border-brand-green text-white shadow-lg shadow-brand-green/20' : 'bg-gray-50 dark:bg-slate-900 border-gray-200 dark:border-slate-700 text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white' }}">
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
                        <span class="font-bold text-gray-900 dark:text-white">Rp {{ number_format($this->subtotal ?? $this->cartTotal, 0, ',', '.') }}</span>
                    </div>
                    @if($this->taxAmount > 0)
                    <div class="flex justify-between text-xs">
                        <span class="text-gray-500 dark:text-slate-400">Tax</span>
                        <span class="font-bold text-gray-900 dark:text-white">Rp {{ number_format($this->taxAmount, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between text-sm pt-2 mt-2 border-t border-gray-100 dark:border-slate-700">
                        <span class="font-bold text-gray-900 dark:text-white">Total</span>
                        <span class="font-extrabold text-brand-green">Rp {{ number_format($this->grandTotal, 0, ',', '.') }}</span>
                    </div>
                </div>
                
                <button wire:click="checkout" class="w-full py-3.5 bg-brand-green hover:bg-green-500 text-white rounded-xl font-bold shadow-lg shadow-brand-green/30 transition-colors">
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
    <div x-show="showCart" x-cloak @click="showCart = false" class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm z-30 transition-opacity"></div>

    <!-- QRIS Modal -->
    @if($showQrisModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm">
            <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-3xl p-6 max-w-xs w-full shadow-2xl text-center">
                <div class="mb-4">
                    <img src="{{ asset('img/qris.jpg') }}" alt="QRIS" class="w-full h-auto mx-auto p-2 border-2 border-gray-100 dark:border-slate-700 rounded-2xl bg-white shadow-inner object-contain max-h-64">
                </div>
                <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-1">Scan QRIS</h3>
                <p class="text-xs text-gray-500 dark:text-slate-400 mb-6">Silakan scan kode QR di atas dengan aplikasi m-banking atau e-wallet Anda.</p>
                
                <div class="bg-brand-green/10 border border-brand-green/20 rounded-xl p-3 mb-6">
                    <div class="text-[10px] text-brand-green font-bold uppercase mb-1">Total Pembayaran</div>
                    <div class="text-xl font-extrabold text-brand-green">Rp {{ number_format($this->grandTotal, 0, ',', '.') }}</div>
                </div>

                <div class="space-y-3">
                    <button wire:click="simulateQrisSuccess" class="w-full py-3 bg-brand-green hover:bg-green-500 text-white rounded-xl font-bold text-sm shadow-md transition-colors">
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
                <div class="absolute top-0 left-0 right-0 h-32 bg-gradient-to-b from-brand-green/10 to-transparent"></div>
                
                <div class="relative z-10">
                    <div class="w-20 h-20 bg-brand-green/15 rounded-full flex items-center justify-center mx-auto mb-4">
                        <div class="w-14 h-14 bg-brand-green rounded-full flex items-center justify-center shadow-lg shadow-brand-green/20">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    </div>
                    
                    <h2 class="text-xl font-extrabold text-gray-900 dark:text-white mb-1">Pesanan Berhasil!</h2>
                    <p class="text-xs text-gray-500 dark:text-slate-400 mb-6">Pesanan Anda langsung masuk ke antrean dapur.</p>
                    
                    <div class="bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl p-4 text-left space-y-2 text-xs mb-6">
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
                            <span class="text-brand-green font-bold uppercase">{{ $completedOrder->payment_status }}</span>
                        </div>
                    </div>
                    
                    <button wire:click="closeSuccess" class="w-full py-3.5 bg-brand-green hover:bg-green-500 text-white rounded-xl font-bold text-sm shadow-md transition-colors">
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
