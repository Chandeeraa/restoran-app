<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-slate-200 tracking-tight flex items-center gap-2">
                <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                Cashier POS & Payments
            </h2>
        </div>

        @if (session()->has('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl relative" role="alert">
                <span class="block sm:inline font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Filters & Search -->
        <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex space-x-2">
                <button wire:click="setFilter('all')" class="px-4 py-2 text-sm font-medium rounded-lg shadow-sm transition-colors {{ $paymentFilter === 'all' ? 'bg-gray-800 text-white border border-gray-800' : 'bg-white text-gray-600 dark:text-slate-400 hover:bg-gray-50 dark:bg-slate-800/50 border border-gray-200 dark:border-slate-700' }}">
                    Semua
                </button>
                <button wire:click="setFilter('unpaid')" class="px-4 py-2 text-sm font-medium rounded-lg shadow-sm transition-colors {{ $paymentFilter === 'unpaid' ? 'bg-red-600 text-white border border-red-600' : 'bg-white dark:bg-slate-800 text-gray-600 dark:text-slate-400 hover:bg-red-50 border border-gray-200 dark:border-slate-700' }}">
                    Belum Bayar
                </button>
                <button wire:click="setFilter('paid')" class="px-4 py-2 text-sm font-medium rounded-lg shadow-sm transition-colors {{ $paymentFilter === 'paid' ? 'bg-green-600 text-white border border-green-600' : 'bg-white dark:bg-slate-800 text-gray-600 dark:text-slate-400 hover:bg-green-50 border border-gray-200 dark:border-slate-700' }}">
                    Lunas
                </button>
            </div>
            
            <div class="relative w-full md:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari Order ID / Nama..." 
                    class="block w-full pl-10 pr-3 py-2 border border-gray-200 dark:border-slate-700 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
            </div>
        </div>

        {{-- ===================== MOBILE CARD LAYOUT ===================== --}}
        <div class="block lg:hidden space-y-3">
            @forelse ($orders as $order)
                @php
                    $statusColor = match($order->status) {
                        'pending'   => 'bg-orange-100 text-orange-800',
                        'cooking'   => 'bg-yellow-100 text-yellow-800',
                        'ready'     => 'bg-green-100 text-green-800',
                        'served'    => 'bg-emerald-100 text-emerald-800',
                        'completed' => 'bg-gray-100 text-gray-600',
                        'cancelled' => 'bg-red-100 text-red-700',
                        default     => 'bg-gray-100 text-gray-600',
                    };
                    $statusLabel = $order->status === 'cooking' ? 'Memasak' : ucfirst($order->status);
                @endphp
                <div wire:key="card-{{ $order->id }}"
                     class="bg-white dark:bg-slate-800 rounded-2xl border {{ $order->payment_status === 'unpaid' ? 'border-red-200 dark:border-red-800' : 'border-gray-100 dark:border-slate-700' }} shadow-sm p-4">

                    {{-- Top Row: Queue + Order Info + Payment Status --}}
                    <div class="flex items-start gap-3 mb-3">
                        {{-- Queue Badge --}}
                        @if($order->queue_number)
                        <div class="flex flex-col items-center shrink-0 w-14 py-2 rounded-xl {{ $order->queue_type === 1 ? 'bg-blue-50 border border-blue-200' : 'bg-purple-50 border border-purple-200' }}">
                            <span class="text-[10px] font-bold uppercase {{ $order->queue_type === 1 ? 'text-blue-500' : 'text-purple-500' }}">{{ $order->queue_type === 1 ? 'Cash' : 'QRIS' }}</span>
                            <span class="text-2xl font-black leading-none {{ $order->queue_type === 1 ? 'text-blue-700' : 'text-purple-700' }}">{{ str_pad($order->queue_number, 3, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        @endif

                        {{-- Order Info --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-sm font-bold text-gray-900 dark:text-slate-100 truncate">{{ $order->order_number }}</span>
                                <span class="px-2 py-0.5 text-xs font-semibold rounded-full {{ $statusColor }}">{{ $statusLabel }}</span>
                            </div>
                            @if($order->customer_name)
                                <div class="text-xs font-semibold text-emerald-700 dark:text-emerald-400 mt-0.5">{{ $order->customer_name }}</div>
                            @endif
                            <div class="flex items-center gap-2 mt-1 flex-wrap">
                                <span class="text-xs text-gray-500 dark:text-slate-400">{{ $order->created_at->format('H:i') }}</span>
                                <span class="text-xs text-gray-500 dark:text-slate-400">·</span>
                                <span class="text-xs font-medium text-gray-600 dark:text-slate-400">{{ $order->order_type === 'dine-in' ? 'Dine-in' : 'Takeaway' }}</span>
                                @if($order->table)
                                    <span class="text-xs font-bold px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded-full">Meja {{ $order->table->table_number }}</span>
                                @endif
                            </div>
                        </div>

                        {{-- Payment Status --}}
                        <div class="shrink-0 text-right">
                            <div class="text-base font-extrabold text-gray-900 dark:text-slate-100">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                            @if($order->payment_status === 'paid')
                                <span class="text-xs font-bold text-emerald-600">✓ Lunas</span>
                            @else
                                <span class="text-xs font-bold text-red-500">✗ Belum</span>
                            @endif
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-wrap gap-2 pt-3 border-t border-gray-100 dark:border-slate-700">
                        @if($order->status === 'cancelled')
                            <span class="text-gray-400 italic text-xs py-2 px-3 bg-gray-50 dark:bg-slate-700 rounded-xl border border-gray-100 dark:border-slate-700">Dibatalkan</span>
                        @else
                            @if($order->status !== 'completed')
                                <button wire:click="cancelOrder({{ $order->id }})"
                                    wire:confirm="Batalkan pesanan {{ $order->order_number }}?"
                                    class="flex-1 min-w-[80px] py-2 text-xs font-bold rounded-xl border border-red-200 text-red-600 bg-white dark:bg-slate-800 hover:bg-red-50 transition-colors">
                                    ✕ Batalkan
                                </button>
                                <button wire:click="completeOrder({{ $order->id }})"
                                    class="flex-1 min-w-[80px] py-2 text-xs font-bold rounded-xl text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                                    ✓ Selesai
                                </button>
                            @endif

                            @if($order->payment_status === 'unpaid')
                                <button wire:click="openPaymentModal({{ $order->id }})"
                                    class="flex-1 min-w-[80px] py-2 text-xs font-bold rounded-xl text-white bg-emerald-600 hover:bg-emerald-700 transition-colors">
                                    💳 Bayar
                                </button>
                            @elseif($order->payment_status === 'paid')
                                <a href="{{ route('cashier.receipt', $order->id) }}" target="_blank"
                                    class="flex-1 min-w-[80px] py-2 text-xs font-bold rounded-xl border border-gray-200 dark:border-slate-700 text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-gray-50 text-center transition-colors">
                                    🖨️ Receipt
                                </a>
                            @endif
                        @endif

                        @if(auth()->user()->role === 'admin')
                            <button wire:click="deleteOrder({{ $order->id }})"
                                wire:confirm="HAPUS PERMANEN pesanan {{ $order->order_number }}?"
                                class="py-2 px-3 text-xs font-bold rounded-xl border border-red-200 dark:border-red-800 text-red-500 bg-white dark:bg-slate-800 hover:bg-red-50 transition-colors" title="Hapus">
                                🗑
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-12 text-gray-400 dark:text-slate-500 text-sm">Tidak ada pesanan ditemukan.</div>
            @endforelse
        </div>

        {{-- ===================== DESKTOP TABLE LAYOUT ===================== --}}
        <div class="hidden lg:block bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                    <thead class="bg-gray-50 dark:bg-slate-800/50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Order ID</th>
                            <th scope="col" class="px-4 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Antrian</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Type / Table</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Total</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Payment</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                        @forelse ($orders as $order)
                            <tr wire:key="order-{{ $order->id }}" class="hover:bg-gray-50 dark:bg-slate-800/50 transition-colors {{ $order->payment_status === 'unpaid' ? 'bg-red-50/30' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900 dark:text-slate-100">{{ $order->order_number }}</div>
                                    @if($order->customer_name)
                                        <div class="text-xs font-semibold text-emerald-700 mt-0.5">{{ $order->customer_name }}</div>
                                    @endif
                                    <div class="text-xs text-gray-400">{{ $order->created_at->format('H:i') }}</div>
                                </td>
                                {{-- Queue Number Column --}}
                                <td class="px-4 py-4 whitespace-nowrap">
                                    @if($order->queue_number)
                                        <div class="flex flex-col items-center gap-1">
                                            <span class="text-2xl font-black leading-none {{ $order->queue_type === 1 ? 'text-blue-600' : 'text-purple-600' }}">
                                                {{ str_pad($order->queue_number, 3, '0', STR_PAD_LEFT) }}
                                            </span>
                                            <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full {{ $order->queue_type === 1 ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                                {{ $order->queue_type === 1 ? 'Cash' : 'QRIS' }}
                                            </span>
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-300 dark:text-slate-600">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-slate-100">{{ $order->order_type === 'dine-in' ? 'Dine-in' : 'Takeaway' }}</div>
                                    @if($order->table)
                                        <div class="mt-1">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                Meja {{ $order->table->table_number }}
                                            </span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $order->status === 'pending' ? 'bg-orange-100 text-orange-800' : '' }}
                                        {{ $order->status === 'cooking' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $order->status === 'ready' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $order->status === 'served' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                        {{ $order->status === 'completed' ? 'bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-400' : '' }}
                                        {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                                        {{ $order->status === 'cooking' ? 'Memasak' : ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-slate-100">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($order->payment_status === 'paid')
                                        <span class="inline-flex items-center gap-1 text-sm font-medium text-green-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Paid
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-sm font-medium text-red-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Unpaid
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end gap-2">
                                        @if($order->status === 'cancelled')
                                            <span class="text-gray-400 italic text-xs py-1.5 px-3 bg-gray-50 dark:bg-slate-800/50 rounded-lg border border-gray-100 dark:border-slate-700/50">Dibatalkan</span>
                                        @else
                                            @if($order->status !== 'completed')
                                                <button wire:click="cancelOrder({{ $order->id }})" 
                                                    wire:confirm="Apakah Anda yakin ingin membatalkan pesanan {{ $order->order_number }}?"
                                                    class="inline-flex items-center px-3 py-1.5 border border-red-200 text-xs font-semibold rounded-lg text-red-600 bg-white dark:bg-slate-800 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                                    Batalkan
                                                </button>
                                                
                                                <button wire:click="completeOrder({{ $order->id }})"
                                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-semibold rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                                                    Selesaikan
                                                </button>
                                            @endif

                                            @if($order->payment_status === 'unpaid')
                                                <button wire:click="openPaymentModal({{ $order->id }})" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-semibold rounded-lg shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all">
                                                    Bayar
                                                </button>
                                            @elseif($order->payment_status === 'paid')
                                                <a href="{{ route('cashier.receipt', $order->id) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 shadow-sm text-xs font-semibold rounded-lg text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:bg-slate-800/50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all">
                                                    <svg class="w-4 h-4 mr-1.5 text-gray-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                                    Receipt
                                                </a>
                                            @endif
                                        @endif
                                        
                                        @if(auth()->user()->role === 'admin')
                                            <button wire:click="deleteOrder({{ $order->id }})" 
                                                wire:confirm="PERINGATAN: Apakah Anda yakin ingin MENGHAPUS PERMANEN pesanan {{ $order->order_number }}? Data ini tidak bisa dikembalikan!"
                                                class="inline-flex items-center px-2 py-1.5 border border-red-200 dark:border-red-800 text-xs font-semibold rounded-lg text-red-600 dark:text-red-400 bg-white dark:bg-slate-800 hover:bg-red-50 dark:hover:bg-red-900/30 focus:outline-none transition-colors" title="Hapus Permanen">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-slate-400">
                                    Tidak ada pesanan ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    @if($showPaymentModal && $selectedOrder)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity" wire:click="closePaymentModal"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="inline-block align-bottom bg-white dark:bg-slate-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white dark:bg-slate-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-xl leading-6 font-bold text-gray-900 dark:text-slate-100" id="modal-title">
                                Payment — {{ $selectedOrder->order_number }}
                            </h3>
                            @if($selectedOrder->customer_name)
                                <p class="text-sm text-emerald-700 font-semibold mt-1">👤 {{ $selectedOrder->customer_name }}</p>
                            @endif
                            <div class="mt-4 bg-gray-50 dark:bg-slate-800/50 p-4 rounded-xl space-y-2">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-500 dark:text-slate-400">Subtotal</span>
                                    <span class="text-gray-700 dark:text-slate-300">Rp {{ number_format($selectedOrder->subtotal_price ?? $selectedOrder->total_price, 0, ',', '.') }}</span>
                                </div>
                                @if($selectedOrder->tax_amount > 0)
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-500 dark:text-slate-400">Tax / PPN</span>
                                    <span class="text-gray-700 dark:text-slate-300">Rp {{ number_format($selectedOrder->tax_amount, 0, ',', '.') }}</span>
                                </div>
                                @endif
                                @if($selectedOrder->service_charge_amount > 0)
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-500 dark:text-slate-400">Service Charge</span>
                                    <span class="text-gray-700 dark:text-slate-300">Rp {{ number_format($selectedOrder->service_charge_amount, 0, ',', '.') }}</span>
                                </div>
                                @endif
                                @if($selectedOrder->discount_amount > 0)
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-green-600 font-medium">Diskon ({{ $selectedOrder->discount_code }})</span>
                                    <span class="text-green-600 font-medium">- Rp {{ number_format($selectedOrder->discount_amount, 0, ',', '.') }}</span>
                                </div>
                                @endif
                                <div class="flex justify-between items-center text-sm pt-2 border-t border-gray-200 dark:border-slate-700 mt-2">
                                    <span class="text-gray-500 dark:text-slate-400 font-semibold">Total Tagihan</span>
                                    <span class="text-xl font-bold text-gray-900 dark:text-slate-100">Rp {{ number_format($selectedOrder->total_price, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <div class="mt-6 space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Metode Pembayaran</label>
                                    <select wire:model.live="paymentMethod" class="mt-1 block w-full pl-3 pr-10 py-2.5 text-base border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-xl">
                                        <option value="cash">Cash</option>
                                        <option value="qris">QRIS / E-Wallet</option>
                                        <option value="card">Debit / Credit Card</option>
                                    </select>
                                </div>

                                @if($paymentMethod === 'cash')
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Jumlah Uang Diterima (Rp)</label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 dark:text-slate-400 sm:text-sm">Rp</span>
                                        </div>
                                        <input type="number" wire:model.live.debounce.300ms="amountGiven" class="focus:ring-green-500 focus:border-green-500 block w-full pl-10 sm:text-sm border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 rounded-xl py-2.5" placeholder="0">
                                    </div>
                                    @if($paymentError)
                                        <p class="mt-2 text-sm font-bold text-red-600 bg-red-50 dark:bg-red-900/30 p-2 rounded-lg border border-red-200 dark:border-red-800/50">{{ $paymentError }}</p>
                                    @endif
                                </div>

                                <div class="bg-green-50 p-4 rounded-xl flex justify-between items-center">
                                    <span class="text-green-800 font-medium text-sm">Kembalian</span>
                                    <span class="text-green-900 font-bold text-lg">Rp {{ number_format($change, 0, ',', '.') }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-slate-800/50 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100 dark:border-slate-700/50">
                    <button type="button" wire:click="processPayment" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-2.5 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Confirm Payment
                    </button>
                    <button type="button" wire:click="closePaymentModal" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 shadow-sm px-6 py-2.5 bg-white dark:bg-slate-800 text-base font-medium text-gray-700 dark:text-slate-300 hover:bg-gray-50 dark:bg-slate-800/50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
