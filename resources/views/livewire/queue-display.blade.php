<div x-data="{
    readyNumbers: [],
    rawJson: '',
    timeStr: '',
    init() {
        // Clock tick
        setInterval(() => {
            const d = new Date();
            this.timeStr = d.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        }, 1000);

        // Initial numbers
        this.rawJson = this.$refs.rawInput.value;
        this.readyNumbers = JSON.parse(this.rawJson || '[]');

        // Watch DOM changes to trigger audio call
        this.$watch('rawJson', (newVal) => {
            try {
                const newArray = JSON.parse(newVal || '[]');
                const added = newArray.filter(num => !this.readyNumbers.includes(num));
                if (added.length > 0) {
                    added.forEach(num => {
                        this.announceOrder(num);
                    });
                }
                this.readyNumbers = newArray;
            } catch (e) {
                console.error(e);
            }
        });
    },
    announceOrder(number) {
        // Play synthesizer chime
        this.playChime();
        
        // Delay speech synthesis for beautiful sequence
        setTimeout(() => {
            const formatted = number.toString().split('').join(' ');
            const msg = new SpeechSynthesisUtterance('Panggilan untuk nomor antrean ' + formatted + '. Silakan mengambil hidangan Anda.');
            msg.lang = 'id-ID';
            msg.rate = 0.85;
            msg.pitch = 1.05;
            window.speechSynthesis.speak(msg);
        }, 1200);
    },
    playChime() {
        try {
            const ctx = new (window.AudioContext || window.webkitAudioContext)();
            const now = ctx.currentTime;
            
            const osc1 = ctx.createOscillator();
            const gain1 = ctx.createGain();
            osc1.type = 'sine';
            osc1.frequency.setValueAtTime(587.33, now); // D5 note
            gain1.gain.setValueAtTime(0.08, now);
            gain1.gain.exponentialRampToValueAtTime(0.001, now + 1.0);
            osc1.connect(gain1);
            gain1.connect(ctx.destination);
            osc1.start(now);
            osc1.stop(now + 1.0);

            const osc2 = ctx.createOscillator();
            const gain2 = ctx.createGain();
            osc2.type = 'sine';
            osc2.frequency.setValueAtTime(880, now + 0.15); // A5 note
            gain2.gain.setValueAtTime(0.08, now + 0.15);
            gain2.gain.exponentialRampToValueAtTime(0.001, now + 1.2);
            osc2.connect(gain2);
            gain2.connect(ctx.destination);
            osc2.start(now + 0.15);
            osc2.stop(now + 1.2);
        } catch (e) {
            console.error('Audio Context Error:', e);
        }
    }
}" class="h-screen w-screen flex flex-col bg-[#0b0f19] text-slate-100 overflow-hidden relative p-8 select-none" wire:poll.5s>

    <!-- Hidden Input for monitoring updates -->
    <input type="hidden" x-ref="rawInput" :value="rawJson = '{{ json_encode($readyOrders->pluck('queue_number')->toArray()) }}'">

    <!-- Memphis dynamic bg circles -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none opacity-5">
        <circle cx="10%" cy="10%" r="200" class="fill-emerald-500 absolute"></circle>
        <circle cx="90%" cy="90%" r="300" class="fill-amber-500 absolute"></circle>
    </div>

    <!-- Header -->
    <header class="w-full flex justify-between items-center mb-8 shrink-0 relative z-10 border-b border-slate-800/80 pb-6">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-gradient-to-tr from-emerald-500 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-500/20">
                <i class="fa-solid fa-mug-hot text-white text-2xl"></i>
            </div>
            <div>
                <h1 class="font-serif font-black text-3xl text-emerald-400 tracking-wider">YON RESTO</h1>
                <p class="text-xs text-slate-400 font-medium mt-0.5">Sistem Layar Antrean Utama</p>
            </div>
        </div>
        
        <!-- Live Clock & Status -->
        <div class="flex items-center gap-6">
            <div class="text-right border-r border-slate-800 pr-6">
                <div class="text-xs text-slate-400 font-semibold uppercase tracking-widest">Waktu Lokal</div>
                <div class="text-3xl font-mono font-black text-slate-100" x-text="timeStr || '{{ now()->format('H:i:s') }}'"></div>
            </div>
            <div class="text-right">
                <div class="text-xs text-emerald-400 animate-pulse flex items-center gap-1.5 font-bold uppercase tracking-wider bg-emerald-950/40 border border-emerald-900/50 px-3 py-1.5 rounded-full">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 inline-block animate-ping"></span>
                    Live Streaming
                </div>
            </div>
        </div>
    </header>

    <!-- Main Board Grid -->
    <main class="flex-1 w-full grid grid-cols-1 md:grid-cols-2 gap-8 mb-8 overflow-hidden relative z-10">
        
        <!-- Preparing Column -->
        <div class="bg-slate-900/60 backdrop-blur-md rounded-[2.5rem] p-8 border border-slate-800 flex flex-col overflow-hidden">
            <h2 class="text-2xl font-black text-amber-500 mb-6 flex items-center gap-3 shrink-0 uppercase tracking-wide">
                <span class="w-2.5 h-7 bg-amber-500 rounded-full"></span>
                Sedang Disiapkan (Preparing)
            </h2>
            
            <div class="flex-1 overflow-y-auto no-scrollbar grid grid-cols-2 sm:grid-cols-3 gap-5">
                @forelse($preparingOrders as $order)
                    <div class="bg-[#151b2c] border border-slate-800 rounded-3xl p-6 flex flex-col items-center justify-center shadow-md transform hover:scale-105 transition-transform duration-300">
                        <span class="text-5xl font-black text-amber-400 tracking-tight">
                            {{ str_pad($order->queue_number, 3, '0', STR_PAD_LEFT) }}
                        </span>
                        <span class="text-[9px] font-bold text-slate-400 mt-2 px-2.5 py-0.5 rounded-full bg-slate-800/80 border border-slate-700/50 uppercase tracking-widest">
                            {{ $order->queue_type === 1 ? '🪙 TUNAI' : '📱 QRIS' }}
                        </span>
                    </div>
                @empty
                    <div class="col-span-full h-full flex flex-col items-center justify-center text-slate-500 py-12">
                        <span class="text-6xl mb-4 opacity-50">🍳</span>
                        <p class="text-base font-semibold">Semua hidangan selesai disiapkan</p>
                        <p class="text-xs opacity-65 mt-1">Belum ada pesanan aktif dalam antrean dapur</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Ready to Serve Column -->
        <div class="bg-slate-900/60 backdrop-blur-md rounded-[2.5rem] p-8 border border-emerald-950 flex flex-col overflow-hidden ring-4 ring-emerald-950/20">
            <h2 class="text-2xl font-black text-emerald-400 mb-6 flex items-center gap-3 shrink-0 uppercase tracking-wide">
                <span class="w-2.5 h-7 bg-emerald-400 rounded-full animate-pulse"></span>
                Silakan Ambil (Ready)
            </h2>
            
            <div class="flex-1 overflow-y-auto no-scrollbar grid grid-cols-2 sm:grid-cols-3 gap-5">
                @forelse($readyOrders as $order)
                    <div class="ready-number-item bg-emerald-950/20 border-2 border-emerald-500/30 rounded-3xl p-6 flex flex-col items-center justify-center shadow-lg shadow-emerald-950/20 relative overflow-hidden" data-number="{{ $order->queue_number }}">
                        <!-- Glowing ambient indicator -->
                        <div class="absolute -inset-0.5 bg-gradient-to-tr from-emerald-500/10 to-transparent opacity-30 rounded-3xl pointer-events-none"></div>
                        
                        <span class="text-5xl font-black text-emerald-400 tracking-tight animate-pulse">
                            {{ str_pad($order->queue_number, 3, '0', STR_PAD_LEFT) }}
                        </span>
                        <span class="text-[9px] font-bold text-emerald-300 mt-2 px-2.5 py-0.5 rounded-full bg-emerald-900/30 border border-emerald-800/40 uppercase tracking-widest">
                            {{ $order->queue_type === 1 ? '🪙 TUNAI' : '📱 QRIS' }}
                        </span>
                    </div>
                @empty
                    <div class="col-span-full h-full flex flex-col items-center justify-center text-slate-500 py-12">
                        <span class="text-6xl mb-4 opacity-50">🛎️</span>
                        <p class="text-base font-semibold">Menunggu pesanan siap</p>
                        <p class="text-xs opacity-65 mt-1">Nomor pesanan yang siap saji akan berkedip hijau di sini</p>
                    </div>
                @endforelse
            </div>
        </div>

    </main>

    <!-- Scrolling Ticker Footer -->
    <footer class="w-full h-12 bg-slate-900 rounded-2xl shrink-0 flex items-center overflow-hidden border border-slate-800 relative z-10 px-4">
        <div class="w-28 shrink-0 font-bold text-xs uppercase tracking-widest text-emerald-400 border-r border-slate-800 flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span> Info Utama
        </div>
        <div class="flex-1 overflow-hidden relative">
            <div class="absolute w-max flex gap-16 text-xs font-semibold text-slate-300 animate-[marquee_25s_linear_infinite]">
                <span>🔔 SILAKAN COCOKKAN NOMOR ANTRIAN ANDA YANG TAMPIL DI LAYAR SEBELUM MENGAMBIL HIDANGAN DI COUNTER</span>
                <span>🍽️ HARAP TUNJUKKAN BUKTI STRUK PEMBAYARAN MANDIRI KEPADA PETUGAS PELAYAN KAMI</span>
                <span>✨ DAPATKAN PROMO MENARIK SETIAP BULANNYA DENGAN MENDAFTAR SEBAGAI MEMBER SETIA YON RESTO</span>
            </div>
        </div>
    </footer>

    <!-- Style overrides for custom styling -->
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        @keyframes marquee {
            0% { transform: translateX(50vw); }
            100% { transform: translateX(-100%); }
        }
        
        .animate-\[marquee_25s_linear_infinite\] {
            animation: marquee 35s linear infinite;
        }
    </style>
</div>
