<div class="min-h-screen bg-gray-50 py-10" wire:poll.5s>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-indigo-600 tracking-tight">Status Pesanan</h1>
            @if($order->customer_name)
                <p class="mt-2 text-gray-700 font-semibold text-lg">Halo, {{ $order->customer_name }}! 👋</p>
            @endif
            <p class="mt-1 text-gray-500 text-sm">Nomor Pesanan: <span class="font-bold text-gray-900">{{ $order->order_number }}</span></p>
        </div>

        @if($order->status === 'cancelled')
            <div class="bg-red-50 border border-red-200 rounded-3xl p-8 text-center shadow-sm mb-8">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                    <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </div>
                <h2 class="text-xl font-bold text-red-900 mb-2">Pesanan Dibatalkan</h2>
                <p class="text-red-700">Mohon maaf, pesanan Anda dibatalkan. Silakan hubungi kasir atau pelayan untuk informasi lebih lanjut.</p>
            </div>
        @else
            <!-- Status Timeline -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 mb-8">
                @php
                    $stages = ['pending', 'cooking', 'ready', 'served', 'completed'];
                    $currentStageIndex = array_search($order->status, $stages);
                    if ($currentStageIndex === false) $currentStageIndex = 0;
                    
                    // If completed, just treat it as served for the timeline
                    $displayStageIndex = $currentStageIndex >= 3 ? 3 : $currentStageIndex;
                @endphp

                <div class="relative">
                    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-gray-100">
                        <div style="width: {{ ($displayStageIndex / 3) * 100 }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-indigo-500 transition-all duration-500"></div>
                    </div>
                    <div class="flex justify-between w-full text-xs sm:text-sm font-medium">
                        <div class="text-center {{ $displayStageIndex >= 0 ? 'text-indigo-600' : 'text-gray-400' }}">
                            <div class="mt-2">Pending</div>
                            <div class="text-xs font-normal text-gray-500 mt-1 hidden sm:block">Menunggu Dapur</div>
                        </div>
                        <div class="text-center {{ $displayStageIndex >= 1 ? 'text-indigo-600' : 'text-gray-400' }}">
                            <div class="mt-2">Diproses</div>
                            <div class="text-xs font-normal text-gray-500 mt-1 hidden sm:block">Sedang Dimasak</div>
                        </div>
                        <div class="text-center {{ $displayStageIndex >= 2 ? 'text-indigo-600' : 'text-gray-400' }}">
                            <div class="mt-2">Siap</div>
                            <div class="text-xs font-normal text-gray-500 mt-1 hidden sm:block">Menunggu Diantar</div>
                        </div>
                        <div class="text-center {{ $displayStageIndex >= 3 ? 'text-indigo-600' : 'text-gray-400' }}">
                            <div class="mt-2">Selesai</div>
                            <div class="text-xs font-normal text-gray-500 mt-1 hidden sm:block">Pesanan Selesai</div>
                        </div>
                    </div>
                </div>

                <!-- Current Status Big Display -->
                <div class="mt-10 text-center">
                    @if($order->status === 'pending')
                        <div class="inline-flex items-center justify-center p-3 bg-orange-50 text-orange-600 rounded-full mb-4">
                            <svg class="w-8 h-8 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Menunggu Konfirmasi</h2>
                        <p class="text-gray-500 mt-2">Pesanan Anda sudah masuk dan sedang menunggu diproses oleh dapur.</p>
                    @elseif($order->status === 'cooking')
                        <div class="inline-flex items-center justify-center p-3 bg-blue-50 text-blue-600 rounded-full mb-4">
                            <svg class="w-8 h-8 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z"></path></svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Sedang Dimasak</h2>
                        <p class="text-gray-500 mt-2">Koki kami sedang menyiapkan makanan lezat Anda. Mohon bersabar ya!</p>
                    @elseif($order->status === 'ready')
                        <div class="inline-flex items-center justify-center p-3 bg-green-50 text-green-600 rounded-full mb-4">
                            <svg class="w-8 h-8 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Pesanan Siap!</h2>
                        <p class="text-gray-500 mt-2">Makanan Anda sudah siap dan akan segera diantarkan atau siap diambil.</p>
                    @elseif(in_array($order->status, ['served', 'completed']))
                        <div class="inline-flex items-center justify-center p-3 bg-indigo-50 text-indigo-600 rounded-full mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-2a2 2 0 00-2 2v5m0 0H5a2 2 0 01-2-2V5a2 2 0 012-2h2a2 2 0 012 2v5m0 0h4"></path></svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Selamat Menikmati</h2>
                        <p class="text-gray-500 mt-2">Pesanan Anda telah selesai dilayani. Terima kasih telah memesan!</p>
                    @endif
                </div>
            </div>
        @endif

        <!-- Order Summary -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900">Rincian Pesanan</h3>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $order->order_type === 'dine-in' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                    {{ $order->order_type === 'dine-in' ? 'Dine-in (Meja ' . ($order->table->table_number ?? '-') . ')' : 'Takeaway' }}
                </span>
            </div>
            <div class="p-6">
                <ul class="divide-y divide-gray-100">
                    @foreach($order->items as $item)
                        <li class="py-4 flex justify-between">
                            <div class="flex items-start">
                                <span class="font-medium text-gray-900 mr-3">{{ $item->quantity }}x</span>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $item->menu->name ?? 'Menu Dihapus' }}</p>
                                    @if($item->notes)
                                        <p class="text-sm text-gray-500 mt-1">Catatan: {{ $item->notes }}</p>
                                    @endif
                                </div>
                            </div>
                            <span class="font-medium text-gray-900">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="p-6 bg-gray-50 border-t border-gray-100">
                <div class="flex justify-between items-center">
                    <span class="text-gray-500 font-medium">Total Tagihan</span>
                    <span class="text-2xl font-bold text-indigo-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
                <div class="mt-2 flex justify-between items-center text-sm">
                    <span class="text-gray-500">Status Pembayaran</span>
                    <span class="font-medium {{ $order->payment_status === 'paid' ? 'text-green-600' : 'text-red-600' }}">
                        {{ $order->payment_status === 'paid' ? 'LUNAS' : 'BELUM DIBAYAR' }}
                    </span>
                </div>
            </div>
        </div>
        
        <div class="mt-8 text-center space-y-4">
            <a href="{{ route('order') }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm transition-colors">
                &larr; Pesan Menu Lainnya
            </a>

            @if($order->status === 'pending')
                <div x-data="{ confirm: false }">
                    <div x-show="!confirm">
                        <button @click="confirm = true"
                            class="block w-full text-center text-red-500 hover:text-red-700 font-medium text-sm transition-colors border border-red-200 hover:border-red-400 rounded-xl py-3 px-4 hover:bg-red-50">
                            Batalkan Pesanan
                        </button>
                    </div>
                    <div x-show="confirm" x-cloak class="bg-red-50 border border-red-200 rounded-2xl p-5">
                        <p class="text-sm font-medium text-red-800 mb-4">⚠️ Apakah Anda yakin ingin membatalkan pesanan ini? Tindakan ini tidak bisa dibatalkan.</p>
                        <div class="flex gap-3">
                            <button wire:click="cancelOrder" wire:loading.attr="disabled"
                                class="flex-1 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-xl transition-colors">
                                <span wire:loading.remove wire:target="cancelOrder">Ya, Batalkan</span>
                                <span wire:loading wire:target="cancelOrder">Memproses...</span>
                            </button>
                            <button @click="confirm = false"
                                class="flex-1 py-2.5 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-colors">
                                Tidak, Kembali
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        
    </div>
</div>
