<div class="min-h-screen bg-gradient-to-br from-slate-50 via-indigo-50/30 to-slate-50 dark:from-slate-900 dark:via-slate-800/50 dark:to-slate-900 py-8"
    wire:poll.5s
>
    <div class="max-w-2xl mx-auto px-4 sm:px-6">

        {{-- Header --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-indigo-600 shadow-lg shadow-indigo-200 dark:shadow-indigo-900/50 mb-4">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-slate-100">Tracking Pesanan</h1>
            @if($order->customer_name)
                <p class="mt-1 text-gray-600 dark:text-slate-400">Halo, <span class="text-indigo-600 font-bold">{{ $order->customer_name }}</span>! 👋</p>
            @endif
            <p class="mt-1 text-xs text-gray-400 font-mono tracking-wider">{{ $order->order_number }}</p>
        </div>

        @if($order->status === 'cancelled')
            {{-- DIBATALKAN --}}
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-3xl p-8 text-center mb-6">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                    <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-red-900 dark:text-red-400 mb-2">Pesanan Dibatalkan</h2>
                <p class="text-red-700 dark:text-red-300 text-sm">Mohon maaf, pesanan Anda dibatalkan. Silakan hubungi kasir.</p>
            </div>

        @else

            {{-- NOTIFIKASI READY (untuk makanan) --}}
            @if($order->status === 'ready' && $hasFood)
                <div class="mb-6 bg-green-50 dark:bg-green-900/20 border-2 border-green-400 dark:border-green-600 rounded-3xl p-5 text-center shadow-lg animate-pulse">
                    <div class="text-4xl mb-2">🔔</div>
                    <h2 class="text-xl font-bold text-green-800 dark:text-green-300">Pesanan Anda Siap Diambil!</h2>
                    <p class="text-green-700 dark:text-green-400 text-sm mt-1">Silakan menuju counter untuk mengambil pesanan.</p>
                </div>
            @endif

            {{-- TIMELINE --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6 sm:p-8 mb-6">

                @php
                    $statusMap = [
                        'pending'   => 0,
                        'cooking'   => 1,
                        'ready'     => 2,
                        'served'    => 3,
                        'completed' => 3,
                    ];
                    $currentIdx = $statusMap[$order->status] ?? 0;

                    $stages = [
                        ['label' => 'Diterima',  'sub' => 'Pesanan masuk ke dapur',  'icon' => '📋'],
                        ['label' => 'Dimasak',   'sub' => 'Sedang disiapkan',        'icon' => '👨‍🍳'],
                        ['label' => 'Siap!',     'sub' => 'Siap untuk diambil',      'icon' => '✅'],
                        ['label' => 'Selesai',   'sub' => 'Selamat menikmati',       'icon' => '🍽️'],
                    ];
                @endphp

                {{-- Progress bar --}}
                <div class="relative h-2 bg-gray-100 dark:bg-slate-700 rounded-full mb-8 overflow-hidden">
                    <div class="absolute inset-y-0 left-0 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-full transition-all duration-700"
                         style="width: {{ $currentIdx > 0 ? ($currentIdx / (count($stages) - 1)) * 100 : 5 }}%">
                    </div>
                </div>

                {{-- Stage icons --}}
                <div class="grid grid-cols-4 gap-2">
                    @foreach($stages as $i => $stage)
                        @php
                            $done   = $i < $currentIdx;
                            $active = $i === $currentIdx;
                            $future = $i > $currentIdx;
                        @endphp
                        <div class="flex flex-col items-center">
                            <div class="relative w-12 h-12 rounded-full flex items-center justify-center text-xl mb-2 transition-all duration-300
                                {{ $active ? 'bg-indigo-600 shadow-lg shadow-indigo-200 dark:shadow-indigo-900/50 ring-4 ring-indigo-100 dark:ring-indigo-900/30 scale-110'
                                   : ($done ? 'bg-indigo-100 dark:bg-indigo-900/40'
                                   : 'bg-gray-100 dark:bg-slate-700 opacity-40') }}">
                                {{ $stage['icon'] }}
                                @if($done)
                                    <span class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-indigo-600 flex items-center justify-center">
                                        <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </span>
                                @endif
                            </div>
                            <span class="text-xs font-semibold text-center leading-tight
                                {{ $active ? 'text-indigo-600' : ($done ? 'text-gray-700 dark:text-slate-300' : 'text-gray-400 dark:text-slate-600') }}">
                                {{ $stage['label'] }}
                            </span>
                            <span class="text-xs text-gray-400 dark:text-slate-500 text-center hidden sm:block leading-tight mt-0.5">
                                {{ $stage['sub'] }}
                            </span>
                        </div>
                    @endforeach
                </div>

                {{-- Status message --}}
                <div class="mt-8 text-center">
                    @if($order->status === 'pending')
                        <div class="inline-flex items-center gap-2 bg-orange-50 dark:bg-orange-900/20 text-orange-700 dark:text-orange-300 rounded-2xl px-5 py-3">
                            <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            <span class="font-semibold text-sm">Menunggu dapur memproses pesanan...</span>
                        </div>

                    @elseif($order->status === 'cooking')
                        <div class="inline-flex items-center gap-2 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 rounded-2xl px-5 py-3">
                            <span class="text-xl animate-bounce inline-block">🔥</span>
                            <span class="font-semibold text-sm">Koki sedang memasak pesanan Anda!</span>
                        </div>

                    @elseif($order->status === 'ready')
                        <div class="inline-flex items-center gap-2 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 rounded-2xl px-5 py-3">
                            <svg class="w-5 h-5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="font-semibold text-sm">Pesanan Anda sudah siap! Silakan diambil. 🎉</span>
                        </div>

                    @elseif(in_array($order->status, ['served', 'completed']))
                        <div class="inline-flex items-center gap-2 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-300 rounded-2xl px-5 py-3">
                            <span class="text-xl">🙏</span>
                            <span class="font-semibold text-sm">Selamat menikmati! Terima kasih. 😊</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Rincian pesanan --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700/50 overflow-hidden mb-6">
                <div class="p-5 border-b border-gray-100 dark:border-slate-700/50 flex items-center justify-between">
                    <h3 class="font-bold text-gray-900 dark:text-slate-100">Rincian Pesanan</h3>
                    <span class="text-xs px-3 py-1 rounded-full font-semibold
                        {{ $order->order_type === 'dine-in' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                        {{ $order->order_type === 'dine-in'
                            ? '🪑 Meja ' . ($order->table->table_number ?? '-')
                            : '🥡 Takeaway' }}
                    </span>
                </div>
                <ul class="divide-y divide-gray-50 dark:divide-slate-700/50">
                    @foreach($order->items as $item)
                        <li class="px-5 py-4 flex items-center justify-between">
                            <div class="flex items-start gap-3">
                                <span class="flex-shrink-0 w-7 h-7 rounded-full bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 flex items-center justify-center text-xs font-bold">
                                    {{ $item->quantity }}
                                </span>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-slate-100">
                                        {{ $item->menu->name ?? 'Menu Dihapus' }}
                                    </p>
                                    @if($item->menu && $item->menu->category)
                                        <span class="text-xs {{ $item->menu->category->is_drink ? 'text-blue-500' : 'text-orange-500' }}">
                                            {{ $item->menu->category->is_drink ? '🧃 Minuman' : '🍽️ Makanan' }}
                                        </span>
                                    @endif
                                    @if($item->notes)
                                        <p class="text-xs text-gray-400 dark:text-slate-500 mt-0.5">📝 {{ $item->notes }}</p>
                                    @endif
                                </div>
                            </div>
                            <span class="text-sm font-semibold text-gray-700 dark:text-slate-300">
                                Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                            </span>
                        </li>
                    @endforeach
                </ul>
                <div class="px-5 py-4 bg-gray-50 dark:bg-slate-800/50 border-t border-gray-100 dark:border-slate-700/50">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500 font-medium">Total Tagihan</span>
                        <span class="text-xl font-bold text-indigo-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                    @if($order->discount_amount > 0)
                        <div class="flex justify-between items-center mt-1">
                            <span class="text-xs text-gray-400">Diskon ({{ $order->discount_code }})</span>
                            <span class="text-xs font-semibold text-green-600">-Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between items-center mt-1">
                        <span class="text-xs text-gray-400">Status Pembayaran</span>
                        <span class="text-xs font-bold {{ $order->payment_status === 'paid' ? 'text-green-600' : 'text-red-500' }}">
                            {{ $order->payment_status === 'paid' ? '✅ LUNAS' : '⏳ BELUM DIBAYAR' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Tombol Batalkan (hanya status pending) --}}
            @if($order->status === 'pending')
                <div x-data="{ confirm: false }" class="mb-6">
                    <div x-show="!confirm">
                        <button @click="confirm = true"
                            class="w-full text-center text-red-500 hover:text-red-700 font-medium text-sm border border-red-200 hover:border-red-400 rounded-2xl py-3 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                            Batalkan Pesanan
                        </button>
                    </div>
                    <div x-show="confirm" x-cloak class="bg-red-50 dark:bg-red-900/20 border border-red-200 rounded-2xl p-5">
                        <p class="text-sm font-medium text-red-800 dark:text-red-300 mb-4">⚠️ Apakah Anda yakin ingin membatalkan pesanan ini?</p>
                        <div class="flex gap-3">
                            <button wire:click="cancelOrder"
                                class="flex-1 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-xl transition-colors">
                                Ya, Batalkan
                            </button>
                            <button @click="confirm = false"
                                class="flex-1 py-2.5 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-700 dark:text-slate-300 text-sm font-bold rounded-xl hover:bg-gray-50 transition-colors">
                                Tidak
                            </button>
                        </div>
                    </div>
                </div>
            @endif

        @endif

        <div class="text-center mt-4">
            <a href="{{ route('order') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium transition-colors">
                ← Pesan Menu Lainnya
            </a>
        </div>

    </div>

    {{-- ============================================================
         AUDIO NOTIFIKASI — Web Audio API (ding! saat status = ready)
         Hanya dimainkan jika order berisi makanan ($shouldPlayAudio)
    ============================================================ --}}
    @if($shouldPlayAudio)
    <script>
    (function () {
        // Cegah double-play jika sudah pernah diputar di session ini
        const key = 'audio_played_{{ $order->order_number }}';
        if (sessionStorage.getItem(key)) return;

        function playReadySound() {
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const notes = [880, 1047, 1319]; // A5 - C6 - E6

                notes.forEach((freq, i) => {
                    setTimeout(() => {
                        const osc  = ctx.createOscillator();
                        const gain = ctx.createGain();
                        osc.connect(gain);
                        gain.connect(ctx.destination);
                        osc.type = 'sine';
                        osc.frequency.setValueAtTime(freq, ctx.currentTime);
                        gain.gain.setValueAtTime(0.5, ctx.currentTime);
                        gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 1.2);
                        osc.start(ctx.currentTime);
                        osc.stop(ctx.currentTime + 1.2);
                    }, i * 320);
                });

                sessionStorage.setItem(key, '1');
            } catch(e) {
                console.warn('Audio play failed:', e);
            }
        }

        // Coba langsung (beberapa browser mengizinkan tanpa interaksi)
        if (document.readyState === 'complete') {
            playReadySound();
        } else {
            window.addEventListener('load', playReadySound);
        }

        // Fallback: saat user pertama berinteraksi
        const once = () => {
            playReadySound();
            document.removeEventListener('click', once);
            document.removeEventListener('touchstart', once);
        };
        document.addEventListener('click', once, { once: true });
        document.addEventListener('touchstart', once, { once: true });
    })();
    </script>
    @endif

</div>
