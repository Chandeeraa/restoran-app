<div class="flex h-screen bg-[#F4F7F6] w-full overflow-hidden">
    
    <!-- Left Sidebar -->
    <div class="w-64 bg-white shadow-sm flex flex-col justify-between shrink-0 h-full">
        <div class="p-6">
            <!-- Logo -->
            <div class="flex items-center gap-3 mb-10">
                <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600 font-bold text-xl">
                    C
                </div>
                <span class="font-bold text-lg text-gray-800 tracking-tight">CHILI POS</span>
            </div>

            <!-- Nav Links -->
            <nav class="space-y-2">
                <a href="#" class="flex items-center gap-3 px-4 py-3 bg-emerald-600 text-white rounded-full font-medium transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    Menu
                </a>
                <a href="{{ route('cashier.pos') }}" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-full font-medium transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Table Services
                </a>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-full font-medium transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Accounting
                </a>
                <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-full font-medium transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Settings
                </a>
            </nav>
        </div>

        <div class="p-6">
            <!-- Users profiles -->
            <div class="space-y-3 mb-6">
                <div class="flex items-center gap-3 px-3 py-2 border border-gray-100 rounded-full cursor-pointer hover:bg-gray-50">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-xs font-bold text-emerald-700">
                        {{ substr(auth()->user()->name, 0, 2) }}
                    </div>
                    <span class="text-sm font-medium text-gray-700 truncate">{{ auth()->user()->name }}</span>
                </div>
            </div>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 text-gray-500 hover:text-red-600 font-medium transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-full overflow-hidden relative">
        
        <!-- Header -->
        <header class="h-20 flex items-center px-8 shrink-0">
            <div class="flex items-center w-full max-w-2xl relative">
                <div class="absolute left-4 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search Product here..." class="w-full pl-12 pr-4 py-3 bg-white border-none rounded-full shadow-sm focus:ring-2 focus:ring-emerald-500 outline-none text-sm font-medium text-gray-700">
            </div>
            <div class="ml-auto flex items-center gap-4">
                <button wire:click="openCheckout" class="relative p-3 bg-white rounded-full shadow-sm text-gray-600 hover:text-emerald-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    @if(count($cart) > 0)
                        <span class="absolute top-0 right-0 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center transform translate-x-1 -translate-y-1">{{ array_sum(array_column($cart, 'quantity')) }}</span>
                    @endif
                </button>
            </div>
        </header>

        <!-- Categories -->
        <div class="px-8 mb-6 shrink-0 no-scrollbar overflow-x-auto">
            <div class="flex gap-4 min-w-max pb-2">
                <button wire:click="setCategory(null)" class="flex flex-col items-center justify-center w-24 h-28 rounded-2xl transition-all shadow-sm {{ is_null($activeCategoryId) ? 'bg-emerald-100 text-emerald-800 border-2 border-emerald-500' : 'bg-white text-gray-500 border border-transparent' }}">
                    <div class="mb-2">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    </div>
                    <span class="font-bold text-sm">All</span>
                    <span class="text-xs opacity-70 mt-1">{{ \App\Models\Menu::count() }} items</span>
                </button>
                @foreach($categories as $category)
                    <button wire:click="setCategory({{ $category->id }})" class="flex flex-col items-center justify-center w-28 h-28 rounded-2xl transition-all shadow-sm {{ $activeCategoryId == $category->id ? 'bg-emerald-100 text-emerald-800 border-2 border-emerald-500' : 'bg-white text-gray-500 border border-transparent hover:bg-gray-50' }}">
                        <div class="mb-2 text-emerald-600">
                            @if($category->is_drink)
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2v10z"></path></svg>
                            @else
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            @endif
                        </div>
                        <span class="font-bold text-sm text-gray-800">{{ $category->name }}</span>
                        <span class="text-xs text-gray-400 mt-1">{{ $category->menus()->count() }} items</span>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Menu Grid -->
        <div class="flex-1 px-8 overflow-y-auto no-scrollbar pb-32">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($menus as $menu)
                    @php
                        $inCart = collect($cart)->firstWhere('id', $menu->id);
                    @endphp
                    <div class="bg-white rounded-3xl p-4 shadow-sm flex flex-col transition-all {{ $inCart ? 'border-2 border-emerald-500' : 'border border-transparent hover:shadow-md' }}">
                        <!-- Image -->
                        <div class="h-40 w-full mb-4 relative rounded-2xl overflow-hidden bg-gray-100 flex items-center justify-center">
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
                            <h3 class="font-bold text-gray-800 text-sm leading-snug line-clamp-2 mb-1">{{ $menu->name }}</h3>
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
                                <div class="flex items-center justify-between bg-emerald-50 rounded-xl p-1 border border-emerald-100">
                                    <button wire:click="updateQuantity({{ $menu->id }}, -1)" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white text-emerald-600 shadow-sm hover:bg-emerald-100 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                    </button>
                                    <span class="font-bold text-emerald-800">{{ $inCart['quantity'] }}</span>
                                    <button wire:click="updateQuantity({{ $menu->id }}, 1)" class="w-8 h-8 flex items-center justify-center rounded-lg bg-emerald-600 text-white shadow-sm hover:bg-emerald-700 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </button>
                                </div>
                            @else
                                <button wire:click="addToCart({{ $menu->id }})" class="w-full py-2.5 bg-emerald-50 text-emerald-700 font-bold text-sm rounded-xl hover:bg-emerald-100 transition-colors">
                                    Add to Dish
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Tables Bar (Bottom) -->
        <div class="absolute bottom-0 left-0 right-0 bg-white/90 backdrop-blur-md border-t border-gray-100 py-4 px-8 shrink-0 no-scrollbar overflow-x-auto">
            <div class="flex items-center gap-4 min-w-max">
                <span class="text-sm font-bold text-gray-500 mr-2 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Select Table:
                </span>
                @foreach($tables as $table)
                    @php
                        $isOccupied = $table->status === 'occupied';
                        $isSelected = $selectedTableId === $table->id;
                    @endphp
                    <button 
                        @if(!$isOccupied || $isSelected) wire:click="setTable({{ $table->id }})" @endif
                        class="flex items-center gap-3 px-4 py-2 rounded-full border transition-all 
                        {{ $isSelected ? 'border-emerald-500 ring-2 ring-emerald-200 bg-emerald-50' : ($isOccupied ? 'border-gray-200 bg-gray-50 opacity-60 cursor-not-allowed' : 'border-gray-200 bg-white hover:border-emerald-300') }}">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm 
                            {{ $isSelected ? 'bg-emerald-500 text-white' : ($isOccupied ? 'bg-gray-300 text-gray-600' : 'bg-yellow-400 text-yellow-900') }}">
                            T{{ $table->table_number }}
                        </div>
                        <div class="text-left">
                            <div class="text-xs font-bold text-gray-800">{{ $isOccupied && !$isSelected ? 'Occupied' : 'Table ' . $table->table_number }}</div>
                            <div class="text-[10px] text-gray-400">{{ $table->capacity }} seats</div>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Right Side / Slide-over Cart & Checkout -->
    <div class="fixed inset-y-0 right-0 w-96 bg-white shadow-2xl border-l border-gray-100 transform transition-transform duration-300 ease-in-out z-40 {{ $showCheckout ? 'translate-x-0' : 'translate-x-full' }}">
        <div class="h-full flex flex-col">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-lg font-bold text-gray-800">Current Order</h2>
                <button wire:click="closeCheckout" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6 pb-2">
                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Customer Name</label>
                    <input type="text" wire:model.live.debounce.300ms="customerName" placeholder="Walk-in Customer" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                </div>
            </div>

            <!-- Cart Items -->
            <div class="flex-1 overflow-y-auto px-6 py-2 space-y-4 no-scrollbar">
                @if(empty($cart))
                    <div class="h-full flex flex-col items-center justify-center text-gray-400">
                        <svg class="w-16 h-16 mb-4 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <p class="text-sm font-medium">Cart is empty</p>
                    </div>
                @endif
                @foreach($cart as $item)
                    <div class="flex gap-3 items-center">
                        <div class="w-12 h-12 rounded-lg bg-gray-100 shrink-0 overflow-hidden">
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
            <div class="px-6 py-6 bg-gray-50 border-t border-gray-100 rounded-t-3xl mt-auto">
                <div class="space-y-2 mb-6">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 font-medium">Subtotal</span>
                        <span class="text-gray-800 font-bold">Rp {{ number_format($this->subtotal, 0, ',', '.') }}</span>
                    </div>
                    @if($this->taxAmount > 0)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 font-medium">Tax</span>
                        <span class="text-gray-800 font-bold">Rp {{ number_format($this->taxAmount, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between text-lg pt-2 border-t border-gray-200 mt-2">
                        <span class="text-gray-800 font-bold">Total</span>
                        <span class="text-emerald-600 font-extrabold">Rp {{ number_format($this->total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Payment Method</label>
                    <div class="grid grid-cols-2 gap-2">
                        <button wire:click="$set('paymentMethod', 'cash')" class="py-2.5 rounded-xl text-sm font-bold transition-colors border {{ $paymentMethod === 'cash' ? 'bg-emerald-100 border-emerald-500 text-emerald-800' : 'bg-white border-gray-200 text-gray-600 hover:bg-gray-50' }}">
                            Cash
                        </button>
                        <button wire:click="$set('paymentMethod', 'qris')" class="py-2.5 rounded-xl text-sm font-bold transition-colors border {{ $paymentMethod === 'qris' ? 'bg-emerald-100 border-emerald-500 text-emerald-800' : 'bg-white border-gray-200 text-gray-600 hover:bg-gray-50' }}">
                            QR Code
                        </button>
                    </div>
                </div>

                @if($paymentMethod === 'cash')
                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Amount Given</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold text-sm">Rp</span>
                        <input type="number" wire:model.live.debounce.300ms="amountGiven" placeholder="0" class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm font-bold text-gray-800 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                    </div>
                    @if($paymentError)
                        <p class="text-xs text-red-500 font-medium mt-1.5">{{ $paymentError }}</p>
                    @endif
                    @if($amountGiven && $amountGiven >= $this->total)
                        <div class="flex justify-between items-center mt-2 px-3 py-2 bg-emerald-50 rounded-lg">
                            <span class="text-xs font-bold text-emerald-600 uppercase">Change</span>
                            <span class="text-sm font-extrabold text-emerald-700">Rp {{ number_format($amountGiven - $this->total, 0, ',', '.') }}</span>
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

    <!-- Overlay for slide-over -->
    @if($showCheckout)
        <div wire:click="closeCheckout" class="fixed inset-0 bg-gray-900/20 backdrop-blur-sm z-30 transition-opacity"></div>
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
                    <div class="text-3xl font-black text-emerald-600 mb-8">Rp {{ number_format($completedOrder->total_price, 0, ',', '.') }}</div>
                    
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
