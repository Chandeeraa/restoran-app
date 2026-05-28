<div class="min-h-screen bg-[#FBF9F1] dark:bg-slate-900 text-gray-800 dark:text-slate-200 py-8 relative overflow-hidden font-sans" wire:poll.60s
     x-data="{ toastMessage: null, showToast: false }"
     @show-toast.window="toastMessage = $event.detail.message; showToast = true; setTimeout(() => showToast = false, 3000)">
     
    <!-- Memphis Dot Pattern Backdrop (Senada dengan AdminScreen.kt) -->
    <div class="absolute inset-0 pointer-events-none opacity-25 z-0 bg-[radial-gradient(#D7C3AE_1.5px,transparent_1.5px)] [background-size:24px_24px]"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

        <!-- Header Bar (Senada dengan AdminScreen.kt) -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-gray-150 dark:border-slate-700/50 p-6 mb-8 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-brand-orange/10 dark:bg-brand-orange/20 flex items-center justify-center text-brand-orange shadow-sm shrink-0">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-lg lg:text-xl font-black tracking-wider text-brand-orange uppercase">Admin Executive Dashboard</h1>
                    <p class="text-xs text-gray-500 dark:text-slate-400 font-medium">
                        Operational analytics & logistics controller — Ringkasan {{ $period === 'today' ? 'Hari Ini' : ($period === 'week' ? 'Minggu Ini' : 'Bulan Ini') }}
                    </p>
                </div>
            </div>

            <!-- Filters & Actions -->
            <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
                <!-- Dropdown Filter Waktu (Branded to Orange) -->
                <div x-data="{ open: false }" class="relative z-[50]">
                    <button @click="open = !open" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 text-xs font-black rounded-xl hover:bg-gray-50 dark:hover:bg-slate-700 transition-all shadow-sm border border-gray-150 dark:border-slate-700 uppercase tracking-wider">
                        <svg class="w-4 h-4 text-brand-orange" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Filter: {{ $period === 'today' ? 'Hari Ini' : ($period === 'week' ? 'Minggu Ini' : 'Bulan Ini') }}
                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-gray-100 dark:border-slate-700 overflow-hidden">
                        <a href="#" wire:click.prevent="setPeriod('today')" @click="open = false" class="flex items-center justify-between px-4 py-3 text-xs uppercase font-black {{ $period === 'today' ? 'text-brand-orange font-bold bg-brand-orange/5' : 'text-gray-700 dark:text-slate-300 hover:bg-gray-50' }}">
                            Hari Ini
                            @if($period === 'today')
                                <svg class="w-4 h-4 text-brand-orange" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                            @endif
                        </a>
                        <a href="#" wire:click.prevent="setPeriod('week')" @click="open = false" class="flex items-center justify-between px-4 py-3 text-xs uppercase font-black {{ $period === 'week' ? 'text-brand-orange font-bold bg-brand-orange/5' : 'text-gray-700 dark:text-slate-300 hover:bg-gray-50' }}">
                            Minggu Ini
                            @if($period === 'week')
                                <svg class="w-4 h-4 text-brand-orange" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                            @endif
                        </a>
                        <a href="#" wire:click.prevent="setPeriod('month')" @click="open = false" class="flex items-center justify-between px-4 py-3 text-xs uppercase font-black {{ $period === 'month' ? 'text-brand-orange font-bold bg-brand-orange/5' : 'text-gray-700 dark:text-slate-300 hover:bg-gray-50' }}">
                            Bulan Ini
                            @if($period === 'month')
                                <svg class="w-4 h-4 text-brand-orange" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                            @endif
                        </a>
                    </div>
                </div>

                <!-- CSV Export -->
                <button wire:click="exportToCsv" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 text-xs font-black rounded-xl hover:bg-gray-50 transition-all shadow-sm border border-gray-150 dark:border-slate-700 uppercase tracking-wider">
                    <svg class="w-4 h-4 text-brand-orange" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"></path>
                    </svg>
                    Ekspor CSV
                </button>

                <!-- Print Report Dropdown -->
                <div x-data="{ open: false }" class="relative z-[50]">
                    <button @click="open = !open" class="inline-flex items-center gap-2 px-4 py-2.5 bg-brand-orange text-white text-xs font-black rounded-xl hover:bg-orange-600 transition-all shadow-lg shadow-brand-orange/20 uppercase tracking-wider">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.821l.105-.074A2.25 2.25 0 018.665 13h6.67a2.25 2.25 0 011.84.747l.104.075M16.5 13.5V21a.75.75 0 01-.75.75H8.25a.75.75 0 01-.75-.75v-7.5M21 9a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 9v4.5A2.25 2.25 0 005.25 15.75h13.5A2.25 2.25 0 0021 13.5V9zm-3.375-1.5h.008v.008h-.008V7.5z"></path>
                        </svg>
                        Print Laporan
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-gray-100 dark:border-slate-700 overflow-hidden">
                        <a href="{{ route('admin.report.print', ['period' => $period]) }}" target="_blank" class="flex items-center gap-2 px-4 py-3 text-xs uppercase font-black text-gray-700 dark:text-slate-300 hover:bg-brand-orange/5 transition-colors">
                            📅 Periode Ini
                        </a>
                        <a href="{{ route('admin.report.print', ['period' => 'all']) }}" target="_blank" class="flex items-center gap-2 px-4 py-3 text-xs uppercase font-black text-gray-700 dark:text-slate-300 hover:bg-brand-orange/5 transition-colors">
                            📊 Semua Transaksi
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPI Summary Row Cards (Senada dengan AdminScreen.kt) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            
            <!-- Card 1: Total Revenue -->
            <div class="bg-white dark:bg-slate-800 rounded-[28px] border border-gray-150 dark:border-slate-700/50 p-6 flex flex-col justify-center min-h-[130px] shadow-sm relative group overflow-hidden">
                <div class="absolute -top-12 -right-12 w-28 h-28 bg-brand-orange/5 rounded-full blur-xl group-hover:bg-brand-orange/10 transition-colors"></div>
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-2">Total Pendapatan</span>
                <span class="text-2xl font-black text-brand-orange tracking-tight mb-2">
                    Rp {{ number_format($todayRevenue, 0, ',', '.') }}
                </span>
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-[#10B981]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307L20.25 7.5m-3-1.5h5.25V11.25"></path>
                    </svg>
                    <span class="text-[11px] text-[#10B981] font-black uppercase tracking-wider">+8.2% vs last week</span>
                </div>
            </div>

            <!-- Card 2: Total Orders -->
            <div class="bg-white dark:bg-slate-800 rounded-[28px] border border-gray-150 dark:border-slate-700/50 p-6 flex flex-col justify-center min-h-[130px] shadow-sm relative group overflow-hidden">
                <div class="absolute -top-12 -right-12 w-28 h-28 bg-[#FEC73F]/5 rounded-full blur-xl group-hover:bg-[#FEC73F]/10 transition-colors"></div>
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-2">Total Pesanan</span>
                <span class="text-2xl font-black text-slate-800 dark:text-white tracking-tight mb-2">
                    {{ $todayOrdersCount }} Orders
                </span>
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-[#10B981]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307L20.25 7.5m-3-1.5h5.25V11.25"></path>
                    </svg>
                    <span class="text-[11px] text-[#10B981] font-black uppercase tracking-wider">+12% dynamic</span>
                </div>
            </div>

            <!-- Card 3: Unpaid / Belum Bayar -->
            <div class="bg-white dark:bg-slate-800 rounded-[28px] border border-gray-150 dark:border-slate-700/50 p-6 flex flex-col justify-center min-h-[130px] shadow-sm relative group overflow-hidden">
                <div class="absolute -top-12 -right-12 w-28 h-28 bg-[#EF4444]/5 rounded-full blur-xl group-hover:bg-[#EF4444]/10 transition-colors"></div>
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-2">Belum Bayar</span>
                <span class="text-2xl font-black text-[#EF4444] tracking-tight mb-2">
                    {{ $todayUnpaidCount }} Tagihan
                </span>
                <div class="flex items-center gap-1.5">
                    <span class="inline-block w-2 h-2 rounded-full bg-[#EF4444] animate-pulse"></span>
                    <span class="text-[11px] text-[#EF4444] font-black uppercase tracking-wider">Perlu Ditagih Kasir</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-8">
            
            <!-- LEFT PANEL: PENDAPATAN KATEGORI & MEJA (Col span 7) -->
            <div class="lg:col-span-7 flex flex-col gap-8">
                <!-- Custom Chart: Pendapatan per Kategori (Senada dengan AdminScreen.kt) -->
                <div class="bg-white dark:bg-slate-800 rounded-[28px] border border-gray-150 dark:border-slate-700/50 p-6 shadow-sm">
                    <h3 class="text-sm font-black text-slate-800 dark:text-white uppercase tracking-wider mb-6">Pendapatan per Kategori</h3>
                    
                    @if($revenueByCategory->isEmpty())
                        <div class="text-center py-12 text-gray-400 font-medium">
                            <span class="text-2xl block mb-2">📊</span>
                            Belum ada transaksi lunas untuk divisualisasikan.
                        </div>
                    @else
                        @php 
                            $maxRev = $revenueByCategory->max('total_revenue') ?: 1; 
                        @endphp
                        <div class="space-y-6">
                            @foreach($revenueByCategory as $catRev)
                                @php
                                    $pct = ($catRev->total_revenue / $maxRev);
                                @endphp
                                <div class="flex flex-col">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-xs font-black text-gray-500 uppercase tracking-wider">{{ $catRev->category_name }}</span>
                                        <span class="text-xs font-black text-brand-orange">
                                            Rp {{ number_format($catRev->total_revenue, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <!-- Progress track -->
                                    <div class="w-full h-3.5 bg-gray-100 dark:bg-slate-700 rounded-full overflow-hidden">
                                        <div class="h-full bg-brand-orange rounded-full transition-all duration-700"
                                             style="width: {{ $pct * 100 }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Recent Transactions Logs (Senada dengan AdminScreen.kt) -->
                <div class="bg-white dark:bg-slate-800 rounded-[28px] border border-gray-150 dark:border-slate-700/50 p-6 shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-sm font-black text-slate-800 dark:text-white uppercase tracking-wider">Recent Transactions Logs</h3>
                        <a href="{{ route('cashier.pos') }}" class="text-xs font-black text-brand-orange uppercase tracking-wider hover:underline">Lihat POS →</a>
                    </div>

                    <div class="space-y-4">
                        @forelse($recentOrders as $order)
                            <div class="border border-gray-100 dark:border-slate-700/50 rounded-2xl p-4 flex justify-between items-center hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-brand-orange/10 flex items-center justify-center text-brand-orange shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-xs font-black text-gray-800 dark:text-white uppercase tracking-wide">
                                            {{ $order->order_number }}
                                        </span>
                                        <p class="text-[10px] text-gray-400 font-bold mt-0.5 uppercase tracking-wider">
                                            {{ $order->order_type === 'dine-in' ? 'Meja ' . ($order->table->table_number ?? 'N/A') : 'Takeaway' }} • {{ $order->created_at->format('H:i') }}
                                        </p>
                                    </div>
                                </div>

                                <div class="text-right shrink-0">
                                    <p class="text-xs font-black text-brand-orange">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </p>
                                    <span class="text-[9px] font-black uppercase tracking-widest px-2 py-0.5 rounded {{ $order->payment_status === 'paid' ? 'bg-[#10B981]/15 text-[#10B981]' : ($order->status === 'cancelled' ? 'bg-[#EF4444]/15 text-[#EF4444]' : 'bg-[#F5A623]/15 text-[#F5A623]') }}">
                                        {{ $order->status === 'cancelled' ? 'Batal' : ($order->payment_status === 'paid' ? 'Lunas' : 'Belum Bayar') }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-6 text-xs text-gray-400 font-medium">Belum ada pesanan hari ini.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- RIGHT PANEL: LOGISTICS RESTOCK & TABLE OCCUPANCY (Col span 5) -->
            <div class="lg:col-span-5 flex flex-col gap-8">
                <!-- circular Table occupancy gauge (Senada dengan AdminScreen.kt) -->
                <div class="bg-white dark:bg-slate-800 rounded-[28px] border border-gray-150 dark:border-slate-700/50 p-6 shadow-sm">
                    <h3 class="text-sm font-black text-slate-800 dark:text-white uppercase tracking-wider mb-6">Status Okupansi Meja</h3>
                    @php
                        $occupancyPct = $tableStats['total'] > 0 ? round(($tableStats['occupied'] / $tableStats['total']) * 100) : 0;
                    @endphp

                    <div class="flex items-center justify-center mb-6">
                        <div class="relative w-36 h-36">
                            <svg class="w-36 h-36 -rotate-90" viewBox="0 0 120 120">
                                <circle cx="60" cy="60" r="50" fill="none" stroke="#e2e8f0" stroke-width="12"/>
                                <circle cx="60" cy="60" r="50" fill="none" stroke="#f5a623" stroke-width="12"
                                    stroke-dasharray="{{ round(314 * $occupancyPct / 100) }} 314"
                                    stroke-linecap="round"/>
                            </svg>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span class="text-2xl font-black text-brand-orange">{{ $occupancyPct }}%</span>
                                <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">TERISI</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3.5 border-t border-gray-100 dark:border-slate-700/50 pt-4">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-[#EF4444] inline-block"></span>
                                <span class="text-xs font-black text-gray-500 uppercase tracking-wider">Sedang Terisi</span>
                            </div>
                            <span class="text-xs font-black text-gray-800 dark:text-white">{{ $tableStats['occupied'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-[#10B981] inline-block"></span>
                                <span class="text-xs font-black text-gray-500 uppercase tracking-wider">Tersedia</span>
                            </div>
                            <span class="text-xs font-black text-gray-800 dark:text-white">{{ $tableStats['available'] }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-2 border-t border-gray-50 dark:border-slate-700/30">
                            <span class="text-xs font-black text-gray-400 uppercase tracking-wider">Total Kapasitas Meja</span>
                            <span class="text-xs font-black text-gray-800 dark:text-white">{{ $tableStats['total'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Laporan Restok Bahan Baku (Logistics Restock Center - Senada dengan AdminScreen.kt) -->
                <div class="bg-white dark:bg-slate-800 rounded-[28px] border border-gray-150 dark:border-slate-700/50 p-6 shadow-sm">
                    <h3 class="text-sm font-black text-slate-800 dark:text-white uppercase tracking-wider mb-6">Laporan Restok Menu / Bahan</h3>

                    <div class="space-y-4">
                        @forelse($lowStockMenus as $item)
                            @php
                                $isDanger = $item->stock <= $item->low_stock_threshold;
                                $imagePlaceholder = 'https://lh3.googleusercontent.com/aida-public/AB6AXuD1i7RchsKynIN7ZygJSevM3NtZynXJ2pxiX1fw7GVMr2JlFpECJk5m2fEJoOfdGRxHJgea4Zi897xfMTBgfob6xYJKPBNDu69wCZt-Z5X7x9AnThMt0zdvwfO5KgtAAFSe726kL2mI4wZPSYycluPlAIUSiopwChvxuJURKigxxBTbhKAykpvc7UKYE6KB7lmsDFv1r9hn-YK5mvCk0-1B6T6uckzu_H6AkcZQQprxaXkL_LHGlvBogx63qoWoeCJPIGmxH8WpRboq';
                                // Ripe Avocado Hass fallback image or Fresh Salmon Fallback
                                if(str_contains(strtolower($item->name), 'salmon')) {
                                    $imagePlaceholder = 'https://lh3.googleusercontent.com/aida-public/AB6AXuD1i7RchsKynIN7ZygJSevM3NtZynXJ2pxiX1fw7GVMr2JlFpECJk5m2fEJoOfdGRxHJgea4Zi897xfMTBgfob6xYJKPBNDu69wCZt-Z5X7x9AnThMt0zdvwfO5KgtAAFSe726kL2mI4wZPSYycluPlAIUSiopwChvxuJURKigxxBTbhKAykpvc7UKYE6KB7lmsDFv1r9hn-YK5mvCk0-1B6T6uckzu_H6AkcZQQprxaXkL_LHGlvBogx63qoWoeCJPIGmxH8WpRboq';
                                } elseif(str_contains(strtolower($item->name), 'alpukat') || str_contains(strtolower($item->name), 'avocado')) {
                                    $imagePlaceholder = 'https://lh3.googleusercontent.com/aida-public/AB6AXuBW5LHz9A1Jp85F8flUayFlewAakLMZb3Apd-cO_dnxlO-PQB7saRcZsSfQS2E0SUqtvyHAJ5cQ49VsSkG0_Q8yKAA2nNGuB3G00RoGNimN25NGBVLBobot-IyhhU_Ijw4l2_O_UFSze-RNeq931jS1IEDUqIh6r8Vtnqp35tK8aa7knTVO-uP08TlKRQEq6K-SWPTtFkOQLVqWzSE3zYOk8FsUNkRc5s1-6p05qlPBQkQgSSdWppw4IqJRqZXSn0vco3EijeMW9AMy';
                                }
                            @endphp
                            <div class="border border-gray-100 dark:border-slate-700/50 rounded-2xl p-4 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-all" wire:key="low-stock-{{ $item->id }}">
                                <div class="flex items-center gap-3">
                                    <!-- Image or Food icon -->
                                    <div class="w-14 h-14 rounded-2xl bg-gray-50 border border-gray-150 overflow-hidden flex items-center justify-center shrink-0">
                                        @if($item->image_url)
                                            <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                                        @else
                                            <img src="{{ $imagePlaceholder }}" alt="mockup image" class="w-full h-full object-cover opacity-75">
                                        @endif
                                    </div>
                                    <div>
                                        <span class="text-xs font-black text-gray-800 dark:text-white uppercase tracking-wide block truncate max-w-[130px]">
                                            {{ $item->name }}
                                        </span>
                                        <div class="flex items-center gap-1.5 mt-1">
                                            <span class="w-2 h-2 rounded-full {{ $isDanger ? 'bg-[#EF4444]' : 'bg-[#10B981]' }}"></span>
                                            <span class="text-[10px] {{ $isDanger ? 'text-[#EF4444] font-black' : 'text-gray-400 font-bold' }} uppercase tracking-wider">
                                                Stok: {{ $item->stock }} Porsi
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="shrink-0">
                                    @if($isDanger)
                                        <button wire:click="restockMenu({{ $item->id }})" class="bg-[#EF4444] hover:bg-red-600 text-white font-extrabold text-[10px] px-3 py-2 rounded-lg uppercase tracking-wider active:scale-95 transition-all shadow-md shadow-red-500/20">
                                            RESTOCK NOW
                                        </button>
                                    @else
                                        <span class="bg-[#10B981]/15 text-[#10B981] font-black text-[9px] px-2.5 py-1.5 rounded-lg uppercase tracking-widest">
                                            ESTABLISHED
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-6 text-xs text-gray-400 font-medium">Semua menu memiliki persediaan yang melimpah.</div>
                        @endforelse
                    </div>
                </div>

                <!-- Menu Terlaris Periode Ini -->
                <div class="bg-white dark:bg-slate-800 rounded-[28px] border border-gray-150 dark:border-slate-700/50 p-6 shadow-sm">
                    <h3 class="text-sm font-black text-slate-800 dark:text-white uppercase tracking-wider mb-6">Menu Terlaris Periode Ini</h3>
                    @if($topMenus->isEmpty())
                        <div class="text-center py-6 text-xs text-gray-400 font-medium">Belum ada data periode ini.</div>
                    @else
                        @php 
                            $maxQty = $topMenus->first()->total_qty ?: 1; 
                        @endphp
                        <div class="space-y-4">
                            @foreach($topMenus as $i => $item)
                                <div>
                                    <div class="flex justify-between items-center mb-1.5">
                                        <div class="flex items-center gap-2">
                                            <span class="text-[10px] font-black text-gray-400 w-4 uppercase">#{{ $i + 1 }}</span>
                                            <span class="text-xs font-bold text-gray-700 dark:text-slate-200">{{ $item->menu->name ?? 'Menu Dihapus' }}</span>
                                        </div>
                                        <span class="text-xs font-black text-gray-800 dark:text-white">{{ $item->total_qty }} porsi</span>
                                    </div>
                                    <div class="h-2 bg-gray-100 dark:bg-slate-700 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full bg-gradient-to-r from-brand-orange to-[#FEC73F] transition-all duration-500"
                                             style="width: {{ ($item->total_qty / $maxQty) * 100 }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>

    </div>

    <!-- Action Confirmation Toast notification (Senada dengan AdminScreen.kt toast) -->
    <div x-show="showToast"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="-translate-y-24 opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="translate-y-0 opacity-100"
         x-transition:leave-end="-translate-y-24 opacity-0"
         class="fixed top-12 left-1/2 -translate-x-1/2 z-[999] max-w-sm w-full px-4"
         x-cloak>
        <div class="bg-[#10B981] rounded-2xl shadow-2xl p-4 border border-emerald-400 flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-white font-bold shrink-0">
                ✓
            </div>
            <p class="text-xs font-black text-white uppercase tracking-wider" x-text="toastMessage"></p>
        </div>
    </div>

</div>
