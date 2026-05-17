<div x-data="{ activeTab: @entangle('tab') }" class="min-h-screen">

    {{-- ---- TAB: BERANDA ---- --}}
    <div x-show="activeTab === 'home'" x-cloak>
        {{-- Hero --}}
        <div class="m-4 sm:m-8 relative bg-gradient-to-br from-emerald-700 via-emerald-600 to-emerald-800 px-10 py-16 overflow-hidden shadow-2xl rounded-[2.5rem]">
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-20 -right-20 w-80 h-80 rounded-full bg-emerald-500/20 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 rounded-full bg-emerald-800/40 blur-3xl"></div>
            </div>
            <div class="relative z-10 max-w-xl">
                <span class="inline-block text-xs font-bold uppercase tracking-widest text-emerald-100 bg-emerald-500/30 border border-emerald-400/30 px-3 py-1 rounded-full mb-4 backdrop-blur-sm">✨ Selamat Datang</span>
                <h1 class="text-4xl font-extrabold text-white leading-tight mb-4 drop-shadow-md">Temukan Cita Rasa <br/><span class="text-brand-yellow drop-shadow-sm">Terbaik Kami</span></h1>
                <p class="text-emerald-50 mb-8 text-base drop-shadow-sm">Nikmati pengalaman makan yang luar biasa. Pesan langsung, lacak status, atau reservasi meja untuk Anda.</p>
                <a href="{{ route('order') }}" class="inline-flex items-center gap-2 px-7 py-3.5 bg-white text-emerald-700 font-bold rounded-xl shadow-xl hover:shadow-2xl hover:-translate-y-0.5 transition-all" wire:navigate.hover>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    Lihat Menu & Pesan
                </a>
            </div>
        </div>

        {{-- Quick Action Cards --}}
        <div class="p-4 sm:p-8 grid grid-cols-1 md:grid-cols-3 gap-5">
            <button @click="activeTab = 'track'" class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-md hover:bg-gray-50 dark:hover:bg-slate-700/80 border border-gray-200 dark:border-slate-700 rounded-2xl p-6 text-left transition-all shadow-sm group">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <h3 class="font-bold text-gray-900 dark:text-white mb-1">Lacak Pesanan</h3>
                <p class="text-gray-500 dark:text-slate-400 text-sm">Cek status pesanan Anda secara real-time</p>
            </button>

            <button @click="activeTab = 'reservasi'" class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-md hover:bg-gray-50 dark:hover:bg-slate-700/80 border border-gray-200 dark:border-slate-700 rounded-2xl p-6 text-left transition-all shadow-sm group">
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-500/20 text-purple-600 dark:text-purple-400 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="font-bold text-gray-900 dark:text-white mb-1">Reservasi Meja</h3>
                <p class="text-gray-500 dark:text-slate-400 text-sm">Booking meja untuk kunjungan Anda</p>
            </button>

            <button @click="activeTab = 'meja'" class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-md hover:bg-gray-50 dark:hover:bg-slate-700/80 border border-gray-200 dark:border-slate-700 rounded-2xl p-6 text-left transition-all shadow-sm group">
                <div class="w-12 h-12 bg-brand-green/20 dark:bg-emerald-500/20 text-brand-green dark:text-emerald-400 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                </div>
                <h3 class="font-bold text-gray-900 dark:text-white mb-1">Status Meja</h3>
                <p class="text-gray-500 dark:text-slate-400 text-sm">Lihat meja yang tersedia sekarang</p>
            </button>
        </div>

        {{-- Active Order Banner (auto from session) --}}
        @if($lastOrder)
        @php
            $statusColor = match($lastOrder->status) {
                'pending'   => ['dot' => 'bg-yellow-400 animate-pulse', 'badge' => 'bg-yellow-100 text-yellow-700 border-yellow-200 dark:bg-yellow-500/20 dark:text-yellow-400 dark:border-yellow-500/30', 'label' => 'Menunggu Konfirmasi'],
                'cooking'   => ['dot' => 'bg-orange-400 animate-pulse', 'badge' => 'bg-orange-100 text-orange-700 border-orange-200 dark:bg-orange-500/20 dark:text-orange-400 dark:border-orange-500/30', 'label' => 'Sedang Dimasak 👨‍🍳'],
                'ready'     => ['dot' => 'bg-brand-green', 'badge' => 'bg-brand-green/20 text-brand-green border-brand-green/30 dark:bg-emerald-500/20 dark:text-emerald-400 dark:border-emerald-500/30', 'label' => 'Siap Diambil! ✅'],
                'served'    => ['dot' => 'bg-gray-400', 'badge' => 'bg-gray-100 text-gray-700 border-gray-200 dark:bg-slate-500/20 dark:text-slate-400 dark:border-slate-500/30', 'label' => 'Sudah Disajikan'],
                default     => ['dot' => 'bg-gray-400', 'badge' => 'bg-gray-100 text-gray-700 border-gray-200 dark:bg-slate-500/20 dark:text-slate-400 dark:border-slate-500/30', 'label' => ucfirst($lastOrder->status)],
            };
        @endphp
        <div class="px-4 sm:px-8 pb-8">
            <div class="bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl border border-gray-200 dark:border-slate-700 shadow-sm rounded-2xl p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 animate-fade-in">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-brand-green/20 dark:bg-emerald-500/20 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-brand-green dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-slate-500 uppercase tracking-widest font-bold mb-1">Pesanan Aktif</p>
                        <p class="text-gray-900 dark:text-white font-bold text-base">{{ $lastOrder->order_number }}</p>
                        <div class="flex items-center gap-2 mt-1">
                            <div class="w-2 h-2 rounded-full {{ $statusColor['dot'] }}"></div>
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full border {{ $statusColor['badge'] }}">{{ $statusColor['label'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <a href="{{ route('customer.track', ['order_number' => $lastOrder->order_number]) }}"
                       class="px-4 py-2 bg-brand-green hover:bg-green-500 text-white text-xs font-bold rounded-xl transition-colors shadow-sm">
                        Lihat Detail
                    </a>
                    <button wire:click="clearLastOrder" class="p-2 bg-gray-100 hover:bg-red-100 dark:bg-slate-700 dark:hover:bg-red-500/20 text-gray-500 hover:text-red-500 dark:text-slate-400 dark:hover:text-red-400 rounded-xl transition-colors shadow-sm" title="Tutup">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- ---- TAB: LACAK PESANAN ---- --}}
    <div x-show="activeTab === 'track'" x-cloak class="p-4 sm:p-8">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">Lacak Pesanan</h2>
            <p class="text-gray-500 dark:text-slate-400 text-sm">Masukkan nama Anda untuk melihat status pesanan.</p>
        </div>
        <div class="max-w-xl bg-white/80 dark:bg-slate-800/80 backdrop-blur-md border border-gray-200 dark:border-slate-700 shadow-sm rounded-2xl p-6 sm:p-8">
            <div class="w-16 h-16 bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400 rounded-2xl flex items-center justify-center mb-6">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </div>
            <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 dark:text-slate-400 mb-2">Nama Pemesan</label>
            <form wire:submit="trackOrder" class="flex flex-col sm:flex-row gap-3">
                <input type="text" wire:model="trackName" placeholder="Contoh: Budi"
                    class="flex-1 px-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl text-gray-900 dark:text-white text-sm font-medium placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-brand-green outline-none transition-colors">
                <button type="submit" class="px-5 py-3 bg-brand-green hover:bg-green-500 text-white font-bold rounded-xl transition-colors flex items-center justify-center gap-2 text-sm shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    Lacak
                </button>
            </form>
            @error('trackName') <p class="text-red-500 dark:text-red-400 text-xs mt-2">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- ---- TAB: STATUS MEJA ---- --}}
    <div x-show="activeTab === 'meja'" x-cloak class="p-4 sm:p-8">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">Status Meja Live</h2>
            <p class="text-gray-500 dark:text-slate-400 text-sm">Ketersediaan meja restoran kami saat ini.</p>
        </div>
        <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-6 gap-4 sm:gap-5">
            @foreach($tables as $table)
                @php $isOccupied = $table->status === 'occupied'; @endphp
                <div class="group flex flex-col items-center justify-center p-4 rounded-2xl border transition-all duration-300 bg-white/95 dark:bg-slate-800/95 backdrop-blur-xl shadow-md hover:shadow-xl hover:-translate-y-1
                    {{ $isOccupied ? 'border-red-300 dark:border-red-500/30' : 'border-emerald-300 dark:border-emerald-500/30' }}">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center mb-3 font-extrabold text-base shadow-sm transition-transform duration-300 group-hover:scale-110
                        {{ $isOccupied ? 'bg-red-100 text-red-600 dark:bg-red-500/20 dark:text-red-400' : 'bg-emerald-100 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400' }}">
                        T{{ $table->table_number }}
                    </div>
                    <span class="text-[11px] font-extrabold uppercase tracking-widest {{ $isOccupied ? 'text-red-600 dark:text-red-400' : 'text-emerald-700 dark:text-emerald-400' }}">
                        {{ $isOccupied ? 'Terisi' : 'Tersedia' }}
                    </span>
                    <span class="text-[10px] text-gray-500 dark:text-slate-400 mt-1 font-medium">{{ $table->capacity }} Kursi</span>
                </div>
            @endforeach
        </div>

        <div class="flex gap-4 mt-6">
            <div class="flex items-center gap-2 text-xs font-medium text-gray-600 dark:text-slate-400">
                <div class="w-3 h-3 rounded-full bg-brand-green shadow-sm"></div> Tersedia
            </div>
            <div class="flex items-center gap-2 text-xs font-medium text-gray-600 dark:text-slate-400">
                <div class="w-3 h-3 rounded-full bg-red-500 shadow-sm"></div> Terisi
            </div>
        </div>
    </div>

    {{-- ---- TAB: RESERVASI ---- --}}
    <div x-show="activeTab === 'reservasi'" x-cloak class="p-4 sm:p-8">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">Reservasi Meja</h2>
            <p class="text-gray-500 dark:text-slate-400 text-sm">Rencanakan kunjungan Anda. Kami siapkan meja terbaik untuk Anda.</p>
        </div>

        <div class="max-w-xl bg-white/80 dark:bg-slate-800/80 backdrop-blur-md border border-gray-200 dark:border-slate-700 shadow-sm rounded-2xl p-6 sm:p-8">
            @if($showReservationSuccess)
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-brand-green/20 dark:bg-emerald-500/20 text-brand-green dark:text-emerald-400 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h3 class="text-gray-900 dark:text-white font-bold text-lg mb-2">Permintaan Terkirim!</h3>
                    <p class="text-gray-500 dark:text-slate-400 text-sm mb-6">Staf kami akan segera menghubungi Anda untuk konfirmasi reservasi.</p>
                    <button wire:click="$set('showReservationSuccess', false)" class="px-6 py-2 bg-brand-green hover:bg-green-500 text-white rounded-xl font-bold text-sm transition-colors shadow-sm">
                        Buat Reservasi Baru
                    </button>
                </div>
            @else
                <form wire:submit="submitReservation" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-500 dark:text-slate-400 mb-1.5">Nama Lengkap</label>
                            <input type="text" wire:model="resName" class="w-full px-3 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl text-gray-900 dark:text-white text-sm placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-brand-green outline-none transition-colors">
                            @error('resName') <p class="text-red-500 dark:text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-500 dark:text-slate-400 mb-1.5">Nomor HP</label>
                            <input type="text" wire:model="resPhone" class="w-full px-3 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl text-gray-900 dark:text-white text-sm placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-brand-green outline-none transition-colors">
                            @error('resPhone') <p class="text-red-500 dark:text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-500 dark:text-slate-400 mb-1.5">Tanggal</label>
                            <input type="date" wire:model="resDate" class="w-full px-3 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-brand-green outline-none transition-colors">
                            @error('resDate') <p class="text-red-500 dark:text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-500 dark:text-slate-400 mb-1.5">Waktu</label>
                            <input type="time" wire:model="resTime" class="w-full px-3 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-brand-green outline-none transition-colors">
                            @error('resTime') <p class="text-red-500 dark:text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-500 dark:text-slate-400 mb-1.5">Jumlah Tamu</label>
                        <input type="number" wire:model="resGuests" min="1" class="w-full px-3 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-brand-green outline-none transition-colors">
                        @error('resGuests') <p class="text-red-500 dark:text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-500 dark:text-slate-400 mb-1.5">Catatan (Opsional)</label>
                        <textarea wire:model="resNotes" rows="2" class="w-full px-3 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-brand-green outline-none resize-none transition-colors"></textarea>
                    </div>
                    <button type="submit" class="w-full py-3 bg-brand-green hover:bg-green-500 text-white font-bold rounded-xl transition-colors mt-2 shadow-md">
                        Kirim Permintaan Reservasi
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
