<div class="min-h-screen bg-gray-50 flex flex-col relative" x-data="{ showCart: $wire.entangle('showCart') }">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-indigo-600 tracking-tight">Restaurant App</h1>
                <p class="text-sm text-gray-500 font-medium mt-0.5">
                    @if($table_number)
                        Dine-in • Meja {{ $table_number }}
                    @else
                        Takeaway Order
                    @endif
                </p>
            </div>
            @if(count($cart) > 0)
                <button @click="showCart = true" class="relative p-2 bg-indigo-50 rounded-full hover:bg-indigo-100 transition-colors">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span class="absolute top-0 right-0 -mt-1 -mr-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white shadow-sm">
                        {{ collect($cart)->sum('quantity') }}
                    </span>
                </button>
            @endif
        </div>
    </header>

    @if (session()->has('success_order'))
        <div class="max-w-7xl mx-auto mt-6 px-4 sm:px-6 lg:px-8">
            <div class="bg-green-50 border border-green-200 rounded-2xl p-6 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h3 class="text-lg leading-6 font-medium text-green-900 mb-2">Yeay! Pesanan Berhasil</h3>
                <p class="text-sm text-green-700">{{ session('success_order') }}</p>
            </div>
        </div>
    @else
        <!-- Category Navigation (Sticky) -->
        <div class="bg-white border-b border-gray-100 sticky top-[72px] z-30 overflow-x-auto no-scrollbar shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex space-x-2 py-4">
                    @foreach($categories as $category)
                        <button wire:click="setActiveCategory({{ $category->id }})" 
                            class="whitespace-nowrap px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 {{ $activeCategoryId == $category->id ? 'bg-indigo-600 text-white shadow-md transform scale-105' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Menu Grid -->
        <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($menus as $menu)
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300 flex flex-col h-full">
                        <div class="relative aspect-w-4 aspect-h-3 bg-gray-100">
                            @if($menu->image)
                                <img src="{{ Storage::url($menu->image) }}" alt="{{ $menu->name }}" class="object-cover w-full h-48">
                            @else
                                <div class="w-full h-48 flex items-center justify-center text-gray-400">
                                    <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-5 flex flex-col flex-grow">
                            <h3 class="text-lg font-bold text-gray-900 leading-tight">{{ $menu->name }}</h3>
                            <p class="mt-1 text-sm text-gray-500 line-clamp-2">{{ $menu->description }}</p>
                            
                            <div class="mt-auto pt-4 flex items-center justify-between">
                                <span class="text-lg font-bold text-indigo-600">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                                <button wire:click="addToCart({{ $menu->id }})" class="p-2.5 bg-indigo-50 text-indigo-600 rounded-full hover:bg-indigo-600 hover:text-white transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-gray-500">
                        Belum ada menu di kategori ini.
                    </div>
                @endforelse
            </div>
        </main>
    @endif

    <!-- Cart Slide-over Panel -->
    <div x-show="showCart" class="fixed inset-0 z-50 overflow-hidden" style="display: none;">
        <div class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showCart = false"
             x-transition:enter="ease-in-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in-out duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

        <div class="fixed inset-y-0 right-0 max-w-full flex">
            <div class="w-screen max-w-md transform transition ease-in-out duration-300"
                 x-transition:enter="translate-x-full" x-transition:enter-end="translate-x-0"
                 x-transition:leave="translate-x-0" x-transition:leave-end="translate-x-full">
                
                <div class="h-full flex flex-col bg-white shadow-2xl">
                    <div class="flex-1 py-6 overflow-y-auto px-4 sm:px-6">
                        <div class="flex items-start justify-between">
                            <h2 class="text-xl font-bold text-gray-900">Pesanan Anda</h2>
                            <div class="ml-3 h-7 flex items-center">
                                <button @click="showCart = false" class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <span class="sr-only">Close panel</span>
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="mt-8">
                            <div class="flow-root">
                                <ul role="list" class="-my-6 divide-y divide-gray-200">
                                    @forelse($cart as $menuId => $item)
                                        <li class="py-6 flex">
                                            <div class="flex-shrink-0 w-20 h-20 overflow-hidden rounded-xl border border-gray-100">
                                                @if($item['image'])
                                                    <img src="{{ Storage::url($item['image']) }}" class="w-full h-full object-center object-cover">
                                                @else
                                                    <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                                        <svg class="h-6 w-6 text-gray-300" fill="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="ml-4 flex-1 flex flex-col">
                                                <div>
                                                    <div class="flex justify-between text-base font-medium text-gray-900">
                                                        <h3>{{ $item['name'] }}</h3>
                                                        <p class="ml-4">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</p>
                                                    </div>
                                                    <div class="mt-1 flex text-sm text-gray-500">
                                                        Rp {{ number_format($item['price'], 0, ',', '.') }} / item
                                                    </div>
                                                </div>
                                                <div class="flex-1 flex items-end justify-between text-sm mt-3">
                                                    <div class="flex items-center border rounded-lg border-gray-200">
                                                        <button wire:click="decreaseQuantity({{ $menuId }})" class="px-3 py-1 text-gray-600 hover:bg-gray-100 rounded-l-lg">-</button>
                                                        <span class="px-3 py-1 font-medium text-gray-900">{{ $item['quantity'] }}</span>
                                                        <button wire:click="increaseQuantity({{ $menuId }})" class="px-3 py-1 text-gray-600 hover:bg-gray-100 rounded-r-lg">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="py-12 flex justify-center">
                                            <div class="text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                                                <h3 class="mt-2 text-sm font-medium text-gray-900">Keranjang Kosong</h3>
                                                <p class="mt-1 text-sm text-gray-500">Mulai pilih menu favoritmu!</p>
                                            </div>
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>

                    @if(count($cart) > 0)
                        <div class="border-t border-gray-200 py-6 px-4 sm:px-6 bg-gray-50">
                            <div class="flex justify-between text-lg font-bold text-gray-900 mb-4">
                                <p>Total</p>
                                <p>Rp {{ number_format($this->cartTotal, 0, ',', '.') }}</p>
                            </div>
                            <button wire:click="checkout" class="w-full flex justify-center items-center px-6 py-4 border border-transparent rounded-2xl shadow-sm text-base font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                Checkout Pesanan
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</div>
