<div class="py-6" wire:poll.60s>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-slate-200 tracking-tight flex items-center gap-2">
                    <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Dashboard Statistik
                </h2>
                <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">Ringkasan harian — {{ now()->translatedFormat('l, d F Y') }} • Auto-refresh setiap 60 detik</p>
            </div>
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition-all shadow-sm shadow-indigo-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Print Laporan
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-gray-100 dark:border-slate-700 z-50 overflow-hidden">
                    <a href="{{ route('admin.report.print', ['period' => 'today']) }}" target="_blank" class="flex items-center gap-2 px-4 py-3 text-sm text-gray-700 dark:text-slate-300 hover:bg-indigo-50 dark:hover:bg-slate-700 transition-colors">
                        📅 Laporan Hari Ini
                    </a>
                    <a href="{{ route('admin.report.print', ['period' => 'month']) }}" target="_blank" class="flex items-center gap-2 px-4 py-3 text-sm text-gray-700 dark:text-slate-300 hover:bg-indigo-50 dark:hover:bg-slate-700 transition-colors">
                        📆 Laporan Bulan Ini
                    </a>
                    <a href="{{ route('admin.report.print', ['period' => 'all']) }}" target="_blank" class="flex items-center gap-2 px-4 py-3 text-sm text-gray-700 dark:text-slate-300 hover:bg-indigo-50 dark:hover:bg-slate-700 transition-colors">
                        📊 Semua Transaksi
                    </a>
                </div>
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <!-- Revenue -->
            <div class="bg-gradient-to-br from-indigo-500 to-indigo-700 rounded-2xl p-5 text-white shadow-lg shadow-indigo-200 col-span-2">
                <div class="flex items-center gap-3 mb-3">
                    <div class="bg-white dark:bg-slate-800/20 p-2 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <span class="text-sm font-medium opacity-80">Total Pendapatan Hari Ini</span>
                </div>
                <p class="text-3xl font-bold tracking-tight">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
                <p class="text-xs opacity-70 mt-1">dari {{ $todayPaidCount }} transaksi lunas</p>
            </div>

            <!-- Total Orders -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 shadow-sm border border-gray-100 dark:border-slate-700/50">
                <div class="flex items-center gap-3 mb-3">
                    <div class="bg-orange-50 p-2 rounded-xl">
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <span class="text-sm font-medium text-gray-500 dark:text-slate-400">Total Pesanan</span>
                </div>
                <p class="text-3xl font-bold text-gray-900 dark:text-slate-100">{{ $todayOrdersCount }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ $todayCancelledCount }} dibatalkan</p>
            </div>

            <!-- Unpaid -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 shadow-sm border border-gray-100 dark:border-slate-700/50">
                <div class="flex items-center gap-3 mb-3">
                    <div class="bg-red-50 p-2 rounded-xl">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <span class="text-sm font-medium text-gray-500 dark:text-slate-400">Belum Bayar</span>
                </div>
                <p class="text-3xl font-bold text-red-600">{{ $todayUnpaidCount }}</p>
                <p class="text-xs text-gray-400 mt-1">perlu ditagih</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

            <!-- Top Menu -->
            <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6">
                <h3 class="text-base font-bold text-gray-800 dark:text-slate-200 mb-5 flex items-center gap-2">
                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                    Menu Terlaris Hari Ini
                </h3>
                @if($topMenus->isEmpty())
                    <div class="text-center py-8 text-gray-400">
                        <svg class="w-10 h-10 mx-auto mb-2 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        <p class="text-sm">Belum ada data hari ini</p>
                    </div>
                @else
                    @php $maxQty = $topMenus->first()->total_qty; @endphp
                    <div class="space-y-4">
                        @foreach($topMenus as $i => $item)
                            <div>
                                <div class="flex justify-between items-center mb-1.5">
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-bold text-gray-400 w-5">#{{ $i + 1 }}</span>
                                        <span class="text-sm font-semibold text-gray-800 dark:text-slate-200">{{ $item->menu->name ?? 'Menu Dihapus' }}</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-sm font-bold text-gray-900 dark:text-slate-100">{{ $item->total_qty }} porsi</span>
                                        <span class="text-xs text-gray-400 ml-2">Rp {{ number_format($item->total_revenue, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <div class="h-2 bg-gray-100 dark:bg-slate-700 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full bg-gradient-to-r from-indigo-400 to-indigo-600 transition-all duration-500"
                                         style="width: {{ ($item->total_qty / $maxQty) * 100 }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Table Status -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6">
                <h3 class="text-base font-bold text-gray-800 dark:text-slate-200 mb-5 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18M10 6v12M14 6v12"></path></svg>
                    Status Meja
                </h3>
                @php
                    $occupancyPct = $tableStats['total'] > 0
                        ? round(($tableStats['occupied'] / $tableStats['total']) * 100)
                        : 0;
                @endphp
                <div class="flex items-center justify-center mb-6">
                    <div class="relative w-32 h-32">
                        <svg class="w-32 h-32 -rotate-90" viewBox="0 0 120 120">
                            <circle cx="60" cy="60" r="50" fill="none" stroke="#e5e7eb" stroke-width="12"/>
                            <circle cx="60" cy="60" r="50" fill="none" stroke="#6366f1" stroke-width="12"
                                stroke-dasharray="{{ round(314 * $occupancyPct / 100) }} 314"
                                stroke-linecap="round"/>
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-2xl font-bold text-gray-900 dark:text-slate-100">{{ $occupancyPct }}%</span>
                            <span class="text-xs text-gray-400">Terisi</span>
                        </div>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-red-400 inline-block"></span>
                            <span class="text-sm text-gray-600 dark:text-slate-400">Sedang Terisi</span>
                        </div>
                        <span class="font-bold text-gray-900 dark:text-slate-100">{{ $tableStats['occupied'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-green-400 inline-block"></span>
                            <span class="text-sm text-gray-600 dark:text-slate-400">Tersedia</span>
                        </div>
                        <span class="font-bold text-gray-900 dark:text-slate-100">{{ $tableStats['available'] }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-gray-100 dark:border-slate-700/50">
                        <span class="text-sm font-medium text-gray-500 dark:text-slate-400">Total Meja</span>
                        <span class="font-bold text-gray-900 dark:text-slate-100">{{ $tableStats['total'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700/50 flex justify-between items-center">
                <h3 class="text-base font-bold text-gray-800 dark:text-slate-200">Pesanan Terbaru Hari Ini</h3>
                <a href="{{ route('cashier.pos') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">Lihat Semua →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100 dark:divide-slate-700/50">
                    <thead class="bg-gray-50 dark:bg-slate-800/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Pesanan</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Pelanggan</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Tipe</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-slate-700/30">
                        @forelse($recentOrders as $order)
                            <tr class="hover:bg-gray-50 dark:bg-slate-800/50 transition-colors">
                                <td class="px-6 py-3">
                                    <div class="text-sm font-bold text-gray-900 dark:text-slate-100">{{ $order->order_number }}</div>
                                    <div class="text-xs text-gray-400">{{ $order->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-3 text-sm text-gray-700 dark:text-slate-300 font-medium">{{ $order->customer_name ?? '-' }}</td>
                                <td class="px-6 py-3">
                                    <span class="text-xs font-medium {{ $order->order_type === 'dine-in' ? 'text-purple-600' : 'text-blue-600' }}">
                                        {{ $order->order_type === 'dine-in' ? 'Dine-in' . ($order->table ? ' · Meja ' . $order->table->table_number : '') : 'Takeaway' }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-sm font-semibold text-gray-900 dark:text-slate-100">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td class="px-6 py-3">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                        {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-700' : ($order->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-orange-100 text-orange-700') }}">
                                        {{ $order->status === 'cancelled' ? 'Dibatalkan' : ($order->payment_status === 'paid' ? 'Lunas' : 'Belum Bayar') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-400 text-sm">Belum ada pesanan hari ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
