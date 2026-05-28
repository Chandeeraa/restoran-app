<div class="min-h-screen w-full relative py-8 px-4 sm:px-6 overflow-hidden bg-brand-cream dark:bg-slate-900 text-gray-900 dark:text-slate-100 transition-colors duration-300" wire:poll.5s x-data="{ showQr: false, waiterFeedback: null }">
    
    <!-- Memphis Dot Pattern Backdrop (Senada dengan TrackScreen.kt) -->
    <div class="absolute inset-0 pointer-events-none opacity-25 z-0 bg-[radial-gradient(#835500_1.5px,transparent_1.5px)] [background-size:20px_20px]"></div>

    <!-- Background decorative blur circles -->
    <div class="absolute -top-24 -right-24 w-80 h-80 bg-brand-orange/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-24 -left-24 w-96 h-96 bg-brand-yellow/5 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative z-10 max-w-2xl mx-auto">
        
        {{-- App Bar / Header (Senada dengan TrackScreen.kt) --}}
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-2">
                <svg class="w-6 h-6 text-brand-orange drop-shadow-sm shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.905 0-5.64-.73-8.028-2.018m16.056 0A11.95 11.95 0 0012 3m0 0a11.95 11.95 0 00-8.028 2.018"></path>
                </svg>
                <h1 class="text-lg md:text-xl font-black text-brand-orange tracking-tight uppercase">Lacak {{ $order->order_number }}</h1>
            </div>

            <div class="px-4 py-1.5 bg-brand-orange/10 rounded-full border border-brand-orange/20 shadow-sm shrink-0">
                <span class="text-xs font-black text-brand-orange uppercase">
                    Meja {{ $order->table ? $order->table->table_number : 'Takeaway' }}
                </span>
            </div>
        </div>

        @if($order->status === 'cancelled')
            {{-- DIBATALKAN STATE --}}
            <div class="bg-red-500/10 border-2 border-red-500 rounded-[28px] p-8 text-center mb-6 shadow-lg shadow-red-500/5">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-2xl bg-red-500/20 mb-4 border border-red-500/30">
                    <svg class="h-8 w-8 text-red-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <h2 class="text-xl font-black text-red-500 mb-2">Pesanan Anda Dibatalkan</h2>
                <p class="text-red-600 dark:text-red-300 text-xs font-medium max-w-sm mx-auto leading-relaxed">Mohon maaf, pesanan Anda dibatalkan oleh pihak restoran. Silakan temui kasir di counter pembayaran.</p>
            </div>
        @else

            {{-- NOTIFIKASI READY DENGAN ACTION BUTTON --}}
            @if($order->status === 'ready')
                <div class="mb-6 bg-brand-green/10 border-2 border-brand-green rounded-[28px] p-6 text-center shadow-lg shadow-brand-green/5 animate-pulse">
                    <div class="text-4xl mb-3">🔔</div>
                    <h2 class="text-lg font-black text-brand-green uppercase">Pesanan Anda Siap Diambil!</h2>
                    <p class="text-xs text-green-700 dark:text-emerald-300 font-semibold mt-1 mb-5">Silakan tunjukkan struk digital atau nomor antrean ke staf saji.</p>

                    @if($order->payment_status === 'paid')
                        <button wire:click="completeOrder" class="w-full py-3.5 bg-brand-green hover:bg-emerald-600 text-white rounded-xl font-bold shadow-lg shadow-brand-green/20 transition-all active:scale-95 text-xs uppercase tracking-wider">
                            <i class="fas fa-check-circle mr-1.5"></i> Saya Sudah Ambil Pesanan
                        </button>
                    @else
                        <div class="py-2.5 px-4 bg-yellow-500/10 border border-yellow-500/20 rounded-xl text-[11px] font-black text-yellow-600 dark:text-yellow-400 uppercase">
                            Silakan selesaikan pembayaran di kasir terlebih dahulu
                        </div>
                    @endif
                </div>
            @endif

            {{-- 1. Estimasi Waktu Tiba (Time Estimate Widget) --}}
            <div class="bg-white dark:bg-slate-800 rounded-[28px] border border-gray-150 dark:border-slate-700/50 p-6 md:p-8 text-center mb-6 shadow-sm">
                <span class="text-[9px] font-black tracking-widest text-gray-400 dark:text-slate-500 block mb-2 uppercase">ESTIMASI PESANAN TIBA</span>
                @php
                    $minutesText = match ($order->status) {
                        'pending' => '~15 Menit',
                        'cooking' => '~12 Menit',
                        'ready' => 'Pesanan Siap!',
                        default => 'Diterima!',
                    };
                @endphp
                <h2 class="text-3xl font-black text-brand-orange tracking-tight mb-2">{{ $minutesText }}</h2>
                <div class="flex items-center justify-center gap-1.5 text-xs text-gray-500 dark:text-slate-400 font-semibold">
                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Dipesan pukul {{ $order->created_at->format('H:i') }} WIB</span>
                </div>
            </div>

            {{-- 2. Stepper Progress Tracker (Senada dengan TrackScreen.kt) --}}
            <div class="bg-white/95 dark:bg-slate-800/95 rounded-[28px] border border-gray-150 dark:border-slate-700/50 p-6 mb-6 shadow-sm">
                @php
                    $statusMap = [
                        'pending'   => 0,
                        'cooking'   => 1,
                        'ready'     => 2,
                        'served'    => 3,
                        'completed' => 3,
                    ];
                    $currentIdx = $statusMap[$order->status] ?? 0;
                @endphp

                <!-- Stepper Circles -->
                <div class="flex justify-between items-center relative mb-6 px-2">
                    @php
                        $stages = [
                            ['name' => 'Diterima', 'desc' => 'Dapur menerima order', 'icon' => '📋'],
                            ['name' => 'Dimasak', 'desc' => 'Koki sedang memasak', 'icon' => '👨‍🍳'],
                            ['name' => 'Siap', 'desc' => 'Silakan diambil', 'icon' => '🔔'],
                            ['name' => 'Selesai', 'desc' => 'Nikmati hidangan', 'icon' => '🍽️']
                        ];
                    @endphp

                    @foreach($stages as $i => $stage)
                        @php
                            $done = $i < $currentIdx;
                            $active = $i === $currentIdx;
                            $future = $i > $currentIdx;

                            $stepColor = match(true) {
                                $done => 'bg-brand-green border-transparent text-white',
                                $active => 'bg-brand-orange border-transparent text-white ring-4 ring-brand-orange/20 scale-105',
                                default => 'bg-gray-100 dark:bg-slate-900 border-gray-200 dark:border-slate-700 text-gray-400 dark:text-slate-500'
                            };
                            
                            $labelColor = match(true) {
                                $done => 'text-brand-green',
                                $active => 'text-brand-orange',
                                default => 'text-gray-400 dark:text-slate-500'
                            };
                        @endphp
                        <div class="flex flex-col items-center z-10 w-16">
                            <div class="w-11 h-11 rounded-full flex items-center justify-center text-sm font-black border-2 transition-all duration-300 {{ $stepColor }}">
                                @if($done)
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                @else
                                    <span class="text-base leading-none">{{ $stage['icon'] }}</span>
                                @endif
                            </div>
                            <span class="text-[10px] font-black mt-2 text-center tracking-tight uppercase leading-none {{ $labelColor }}">
                                {{ $stage['name'] }}
                            </span>
                        </div>
                    @endforeach
                </div>

                <!-- Info Box Alert Message -->
                @php
                    $alertMessage = match ($order->status) {
                        'pending' => 'Pesanan Anda berhasil dikirim ke dapur. Menunggu persetujuan koki.',
                        'cooking' => 'Chef sedang menyiapkan menu pesanan Anda dengan bahan segar terbaik.',
                        'ready' => 'Pesanan Anda sudah SIAP! Silakan ambil atau panggil pelayan untuk mengantarkannya.',
                        default => 'Pesanan Anda selesai! Selamat menikmati hidangan spesial dari YON RESTO.'
                    };
                @endphp
                <div class="flex items-start gap-3 bg-brand-orange/5 border border-brand-orange/20 rounded-2xl p-4">
                    <svg class="w-5 h-5 text-brand-orange shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 111.063.852l-.708 2.836a.75.75 0 001.063.852l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"></path></svg>
                    <p class="text-[11px] font-bold text-gray-700 dark:text-slate-300 leading-normal">{{ $alertMessage }}</p>
                </div>
            </div>

            {{-- 3. Rincian Pesanan (Order Details Card) --}}
            <div class="bg-white dark:bg-slate-800 rounded-[28px] border border-gray-150 dark:border-slate-700/50 overflow-hidden mb-6 shadow-sm">
                <div class="p-5 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between">
                    <h3 class="font-extrabold text-sm text-gray-900 dark:text-white uppercase tracking-tight">Rincian Hidangan</h3>
                    <span class="text-[10px] px-3 py-1 rounded-full font-black {{ $order->order_type === 'dine-in' ? 'bg-brand-orange/10 text-brand-orange' : 'bg-brand-green/10 text-brand-green' }} uppercase">
                        {{ $order->order_type === 'dine-in' ? '🪑 Makan Di Tempat' : '🥡 Bawa Pulang' }}
                    </span>
                </div>

                <ul class="divide-y divide-gray-100 dark:divide-slate-700">
                    @foreach($order->items as $item)
                        <li class="px-5 py-4 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <span class="flex-shrink-0 w-8 h-8 rounded-xl bg-brand-orange/10 text-brand-orange flex items-center justify-center text-xs font-black border border-brand-orange/20 shadow-sm">
                                    {{ $item->quantity }}x
                                </span>
                                <div>
                                    <p class="text-sm font-extrabold text-gray-900 dark:text-white">
                                        {{ $item->menu->name ?? 'Unknown Menu' }}
                                    </p>
                                    @if($item->notes)
                                        <p class="text-[10px] text-red-500 font-bold mt-1 bg-red-50 dark:bg-red-500/10 border border-red-100 dark:border-red-500/20 px-2 py-0.5 rounded inline-block">📝 {{ $item->notes }}</p>
                                    @endif
                                </div>
                            </div>
                            <span class="text-sm font-black text-gray-800 dark:text-slate-300">
                                Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                            </span>
                        </li>
                    @endforeach
                </ul>

                <div class="p-5 bg-gray-50 dark:bg-slate-800/40 border-t border-gray-100 dark:border-slate-700 space-y-2">
                    <div class="flex justify-between text-xs">
                        <span class="text-gray-500 dark:text-slate-400 font-medium">Subtotal</span>
                        <span class="font-bold text-gray-900 dark:text-white">Rp {{ number_format($order->subtotal_price, 0, ',', '.') }}</span>
                    </div>
                    @if($order->discount_amount > 0)
                        <div class="flex justify-between text-xs text-red-500">
                            <span>Diskon ({{ $order->discount_code }})</span>
                            <span class="font-bold">-Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    @if($order->service_charge_amount > 0)
                        <div class="flex justify-between text-xs text-gray-500 dark:text-slate-400">
                            <span>Service Charge (5%)</span>
                            <span class="font-bold text-gray-900 dark:text-white">Rp {{ number_format($order->service_charge_amount, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    @if($order->tax_amount > 0)
                        <div class="flex justify-between text-xs text-gray-500 dark:text-slate-400">
                            <span>Pajak (Tax 10%)</span>
                            <span class="font-bold text-gray-900 dark:text-white">Rp {{ number_format($order->tax_amount, 0, ',', '.') }}</span>
                        </div>
                    @endif

                    <div class="flex justify-between items-center pt-2.5 mt-2 border-t border-gray-100 dark:border-slate-700">
                        <span class="text-sm font-bold text-gray-900 dark:text-white">Total Tagihan</span>
                        <span class="text-lg font-black text-brand-orange">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between items-center pt-2.5">
                        <span class="text-xs text-gray-500 dark:text-slate-400 font-medium">Status Pembayaran</span>
                        <span class="text-[10px] font-black px-2.5 py-1 rounded-full {{ $order->payment_status === 'paid' ? 'bg-brand-green/10 text-brand-green' : 'bg-red-500/10 text-red-500' }} uppercase">
                            {{ $order->payment_status === 'paid' ? 'LUNAS' : 'Belum Lunas' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- 4. Tombol Aksi Bawah: QR Struk & Panggil Pelayan (Senada dengan TrackScreen.kt) --}}
            <div class="grid grid-cols-2 gap-4 mb-6">
                <!-- QR STRUK Button -->
                <button type="button" @click="showQr = true" class="h-28 bg-white dark:bg-slate-800 border border-gray-150 dark:border-slate-700/50 rounded-3xl shadow-sm flex flex-col items-center justify-center group active:scale-95 transition-all">
                    <div class="w-12 h-12 rounded-2xl bg-brand-orange/10 group-hover:bg-brand-orange/20 flex items-center justify-center text-brand-orange transition-colors shadow-sm mb-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5zM16.5 13.5h.008v.008h-.008V13.5zm3 0h.008v.008h-.008V13.5zm-3 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm3-3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm-6-3h.008v.008h-.008V13.5zm-3 3h.008v.008h-.008v-.008zm3 3h.008v.008H13.5v-.008z"></path></svg>
                    </div>
                    <span class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest leading-none">QR STRUK</span>
                </button>

                <!-- CALL WAITER Button -->
                <button type="button" @click="waiterFeedback = 'Memanggil...'; setTimeout(() => waiterFeedback = 'Tunggu Sebentar', 2000); setTimeout(() => waiterFeedback = null, 3500);" class="h-28 bg-brand-orange hover:bg-orange-500 text-white rounded-3xl shadow-lg shadow-brand-orange/20 flex flex-col items-center justify-center active:scale-95 transition-all">
                    <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center mb-2">
                        <svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0M3.124 7.5A8.969 8.969 0 015.292 3m13.416 0a8.969 8.969 0 012.168 4.5"></path></svg>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest leading-none" x-text="waiterFeedback || 'PANGGIL PELAYAN'"></span>
                </button>
            </div>

            {{-- 5. Tombol Pembatalan Mandiri (hanya status pending) --}}
            @if($order->status === 'pending')
                <div x-data="{ confirm: false }" class="mb-6">
                    <div x-show="!confirm">
                        <button @click="confirm = true"
                            class="w-full text-center text-red-500 hover:text-red-400 font-extrabold text-xs border-2 border-red-500/20 hover:border-red-500/30 rounded-2xl py-3.5 hover:bg-red-500/5 transition-all uppercase tracking-wider">
                            Batalkan Pesanan
                        </button>
                    </div>
                    <div x-show="confirm" x-cloak class="bg-red-500/5 border-2 border-red-500/20 rounded-[24px] p-5">
                        <p class="text-xs font-bold text-red-600 dark:text-red-300 mb-4">⚠️ Apakah Anda yakin ingin membatalkan pesanan ini? Tindakan ini tidak dapat dibatalkan.</p>
                        <div class="flex gap-3">
                            <button wire:click="cancelOrder"
                                class="flex-1 py-2.5 bg-red-600 hover:bg-red-500 text-white text-xs font-black rounded-xl hover:shadow-lg transition-colors uppercase">
                                Ya, Batalkan
                            </button>
                            <button @click="confirm = false"
                                class="flex-1 py-2.5 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-700 dark:text-slate-300 text-xs font-black rounded-xl hover:bg-gray-50 dark:hover:bg-slate-750 transition-colors uppercase">
                                Batal
                            </button>
                        </div>
                    </div>
                </div>
            @endif

        @endif

        {{-- 6. Back Button --}}
        <div class="text-center mt-6">
            <a href="{{ route('order') }}" class="text-xs font-black text-brand-orange hover:text-orange-500 transition-colors uppercase tracking-wider" wire:navigate.hover>
                ← Pesan Menu Lainnya
            </a>
        </div>

    </div>

    <!-- QR Code / E-Struk Modal Sheet -->
    <div x-show="showQr" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm">
        <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-750 rounded-[2rem] p-6 max-w-xs w-full shadow-2xl text-center"
             @click.away="showQr = false">
            <h3 class="font-extrabold text-gray-900 dark:text-white text-base mb-1">E-Struk / QR Pembayaran</h3>
            <p class="text-[10px] text-gray-400 dark:text-slate-500 mb-6">Tunjukkan QR ini ke kasir untuk pemrosesan pembayaran instan via POS Kasir.</p>
            
            <div class="w-48 h-48 bg-white p-3 border-2 border-gray-150 dark:border-slate-700 rounded-2xl shadow-inner mx-auto mb-6 flex items-center justify-center">
                <!-- Synthesized visual representation of QR code using an interactive SVG or icon -->
                <i class="bi bi-qr-code text-[140px] text-gray-900 leading-none"></i>
            </div>

            <div class="bg-brand-orange/10 border border-brand-orange/20 rounded-xl p-3 mb-6">
                <span class="text-[9px] font-black text-brand-orange uppercase block mb-0.5">KODE STRUK</span>
                <span class="text-sm font-black text-brand-orange tracking-wider font-mono">{{ $order->order_number }}</span>
            </div>

            <button type="button" @click="showQr = false" class="w-full py-3 bg-gray-100 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-700 dark:text-slate-300 rounded-xl font-bold text-xs hover:bg-gray-200 dark:hover:bg-slate-700 transition-colors uppercase">
                Tutup
            </button>
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
                        const osc = ctx.createOscillator();
                        const gainNode = ctx.createGain();
                        osc.connect(gainNode);
                        gainNode.connect(ctx.destination);
                        osc.type = 'sine';
                        osc.frequency.setValueAtTime(freq, ctx.currentTime);
                        gainNode.gain.setValueAtTime(0.3, ctx.currentTime);
                        gainNode.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.5);
                        osc.start();
                        osc.stop(ctx.currentTime + 0.5);
                    }, i * 200);
                });
                
                sessionStorage.setItem(key, 'true');
            } catch (e) {
                console.warn('Audio play failed:', e);
            }
        }

        // Jalankan audio setelah interaksi user atau load halaman
        if (document.readyState === 'complete') {
            playReadySound();
        } else {
            window.addEventListener('load', playReadySound);
        }
    })();
    </script>
    @endif

    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        [x-cloak] { display: none !important; }
    </style>
</div>
