<div class="min-h-screen bg-[#0B0F19] text-white py-8 relative overflow-hidden font-sans" wire:poll.10s>
    <!-- Memphis Dot Pattern Backdrop (Senada dengan KdsScreen.kt) -->
    <div class="absolute inset-0 pointer-events-none opacity-[0.07] z-0 bg-[radial-gradient(#1E293B_1.5px,transparent_1.5px)] [background-size:24px_24px]"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Header Bar (Senada dengan KdsScreen.kt) -->
        <div x-data="{ isCallWaiterActive: true }" class="bg-[#0F172A] rounded-3xl border border-white/5 p-6 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 shadow-2xl">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-[#FEC73F]/10 flex items-center justify-center text-[#FEC73F] shadow-sm">
                    <svg class="w-7 h-7 animate-pulse" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 3h6m-6 4h6m-6 4h6m-6 4h6m-3-12v18"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-lg md:text-xl font-black tracking-wider text-white uppercase">Kitchen Display System (KDS)</h1>
                    <p class="text-xs text-slate-400 font-medium">Live cooking logs and table service channels.</p>
                </div>
            </div>

            <!-- Real-time Status Badge & Alert Waiter -->
            <div class="flex items-center gap-3 w-full md:w-auto justify-between md:justify-end">
                <!-- Waiter Alert Card (Interactive mockup from Compose screen) -->
                <template x-if="isCallWaiterActive">
                    <button @click="isCallWaiterActive = false" class="bg-[#EF4444] hover:bg-red-600 text-white font-extrabold text-xs px-4 py-2.5 rounded-xl flex items-center gap-2 active:scale-95 transition-all shadow-lg shadow-red-500/20">
                        <svg class="w-4 h-4 animate-bounce" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"></path>
                        </svg>
                        CALL WAITER: MEJA 12
                        <span class="text-[9px] bg-white/20 px-1.5 py-0.5 rounded ml-1 font-bold">DISMISS</span>
                    </button>
                </template>

                <div class="flex items-center gap-2 bg-slate-900/80 px-4 py-2.5 rounded-xl border border-white/5">
                    <span class="relative flex h-3.5 w-3.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-green-500"></span>
                    </span>
                    <span class="text-xs font-bold text-green-400 tracking-widest uppercase">LIVE KITCHEN</span>
                </div>
            </div>
        </div>

        <!-- Two Column Screen Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- LEFT COLUMN: ACTIVE COOKING TICKETS BOARD (Col span 7) -->
            <div class="lg:col-span-7 flex flex-col gap-6">
                <div class="flex justify-between items-center bg-slate-900/40 p-2 rounded-2xl border border-white/5 px-4">
                    <h2 class="text-sm md:text-base font-black tracking-wider uppercase text-slate-200">Active Cooking Tickets</h2>
                    <span class="bg-[#1E293B] text-[#FEC73F] text-xs font-black px-3.5 py-1.5 rounded-xl border border-white/5">
                        {{ count($orders) }} Tickets
                    </span>
                </div>

                @if(count($orders) === 0)
                    <!-- Empty State -->
                    <div class="bg-[#0F172A] rounded-3xl border border-white/5 p-16 text-center shadow-xl flex flex-col items-center justify-center min-h-[350px]">
                        <div class="w-16 h-16 rounded-full bg-slate-800/50 flex items-center justify-center text-slate-500 mb-4 border border-white/5">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"></path>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-300">No Pending Orders</h3>
                        <p class="text-xs text-slate-500 mt-1 max-w-sm">Waiting for checkouts from customer app. Screen will automatically load incoming orders.</p>
                    </div>
                @else
                    <!-- Scrollable Tickets Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($orders as $order)
                            @php
                                // Border colors per status
                                $borderColor = 'border-slate-800';
                                if($order->status === 'pending') {
                                    $borderColor = 'border-[#F5A623]/60';
                                } elseif($order->status === 'cooking') {
                                    $borderColor = 'border-blue-500/60';
                                } elseif($order->status === 'ready') {
                                    $borderColor = 'border-[#10B981]/60';
                                }

                                // Est minutes based on count
                                $estMin = count($order->items) * 5 + 5;
                            @endphp
                            <div class="bg-[#0F172A] rounded-[24px] border {{ $borderColor }} p-5 shadow-xl flex flex-col justify-between hover:scale-[1.01] hover:shadow-2xl transition-all duration-300 relative group overflow-hidden" wire:key="order-ticket-{{ $order->id }}">
                                
                                <!-- Banner Top Glow -->
                                <div class="absolute top-0 left-0 right-0 h-[3px] {{ $order->status === 'pending' ? 'bg-[#F5A623]' : ($order->status === 'cooking' ? 'bg-blue-500' : 'bg-[#10B981]') }}"></div>

                                <div>
                                    <!-- Header Card -->
                                    <div class="flex justify-between items-center mb-3">
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs font-black text-white bg-white/5 border border-white/10 px-2.5 py-1 rounded-xl">
                                                #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                                            </span>
                                            <!-- Table Badge -->
                                            <span class="text-[9px] font-black px-2 py-0.5 rounded-lg {{ $order->order_type === 'takeaway' ? 'bg-[#EF4444]/25 text-[#EF4444]' : 'bg-[#10B981]/25 text-[#10B981]' }} uppercase tracking-wider">
                                                {{ $order->order_type === 'takeaway' ? 'TAKEAWAY' : 'MEJA ' . ($order->table->table_number ?? 'N/A') }}
                                            </span>
                                        </div>
                                        <span class="text-xs font-black text-[#FEC73F] bg-[#FEC73F]/10 px-2 py-1 rounded-lg">
                                            {{ $estMin }}m est
                                        </span>
                                    </div>

                                    <!-- Customer name if exists -->
                                    @if($order->customer_name)
                                        <div class="flex items-center gap-1.5 mb-4 text-xs font-black text-slate-300">
                                            <span class="text-slate-500">👤</span> {{ $order->customer_name }}
                                        </div>
                                    @endif

                                    <!-- Divider -->
                                    <div class="border-b border-white/5 my-3"></div>

                                    <!-- Items List -->
                                    <ul class="space-y-3 mb-6">
                                        @foreach($order->items as $item)
                                            <li class="flex items-start justify-between gap-3 text-slate-200">
                                                <div class="flex items-start gap-2.5">
                                                    <span class="inline-flex items-center justify-center shrink-0 w-6 h-6 rounded-lg bg-white/5 border border-white/10 text-xs font-black text-[#FEC73F]">
                                                        {{ $item->quantity }}x
                                                    </span>
                                                    <div class="flex flex-col">
                                                        <span class="text-xs font-bold leading-tight">{{ $item->menu->name ?? 'Menu Dihapus' }}</span>
                                                        @if($item->notes)
                                                            <span class="text-[10px] text-[#FEC73F] font-semibold italic mt-0.5">
                                                                Note: {{ $item->notes }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <!-- Actions Footer -->
                                <div class="mt-auto">
                                    <div class="border-t border-white/5 pt-4">
                                        @if($order->status === 'pending')
                                            <button wire:click="updateStatus({{ $order->id }}, 'cooking')" class="w-full bg-[#F5A623] hover:bg-orange-500 text-white font-extrabold text-xs py-3 rounded-xl uppercase tracking-wider flex items-center justify-center gap-2 active:scale-95 transition-all shadow-lg shadow-[#F5A623]/20">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path>
                                                </svg>
                                                START COOKING
                                            </button>
                                        @elseif($order->status === 'cooking')
                                            <button wire:click="updateStatus({{ $order->id }}, 'ready')" class="w-full bg-[#10B981] hover:bg-[#0d9488] text-white font-extrabold text-xs py-3 rounded-xl uppercase tracking-wider flex items-center justify-center gap-2 active:scale-95 transition-all shadow-lg shadow-[#10B981]/20">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"></path>
                                                </svg>
                                                MARK READY
                                            </button>
                                        @elseif($order->status === 'ready')
                                            <button wire:click="updateStatus({{ $order->id }}, 'completed')" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs py-3 rounded-xl uppercase tracking-wider flex items-center justify-center gap-2 active:scale-95 transition-all shadow-lg shadow-blue-500/20">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"></path>
                                                </svg>
                                                COMPLETE & SHIP
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- RIGHT COLUMN: LIVE QUEUE STATUS BOARD (Col span 5) -->
            <div class="lg:col-span-5 flex flex-col gap-6">
                <div class="bg-slate-900/40 p-2 rounded-2xl border border-white/5 px-4 h-[54px] flex items-center">
                    <h2 class="text-sm md:text-base font-black tracking-wider uppercase text-slate-200">Live Queue Status Board</h2>
                </div>

                <div class="grid grid-cols-2 gap-4 h-full min-h-[500px]">
                    <!-- PREPARING COLUMN CARD -->
                    <div class="bg-[#0F172A] rounded-3xl border border-white/5 p-5 flex flex-col shadow-2xl relative">
                        <h3 class="text-xs font-black uppercase text-[#F5A623] tracking-widest border-b border-white/5 pb-3 mb-4">PREPARING</h3>
                        
                        <div class="flex-1 overflow-y-auto space-y-2.5">
                            @php
                                $preparingOrders = $orders->where('status', 'cooking');
                            @endphp

                            @forelse($preparingOrders as $preparing)
                                <div class="flex items-center justify-between bg-white/5 border border-white/10 rounded-xl p-3 hover:bg-white/10 transition-colors">
                                    <div class="flex flex-col">
                                        <span class="text-xs font-bold">#{{ str_pad($preparing->id, 4, '0', STR_PAD_LEFT) }}</span>
                                        <span class="text-[9px] text-[#F5A623] font-bold mt-0.5">
                                            {{ $preparing->order_type === 'takeaway' ? 'Takeaway' : 'Table ' . ($preparing->table->table_number ?? 'N/A') }}
                                        </span>
                                    </div>
                                    <span class="w-2.5 h-2.5 rounded-full bg-[#F5A623] animate-pulse"></span>
                                </div>
                            @empty
                                <div class="h-full flex items-center justify-center text-center">
                                    <span class="text-xs font-bold text-slate-600">Empty</span>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- READY COLUMN CARD -->
                    <div class="bg-[#0F172A] rounded-3xl border border-white/5 p-5 flex flex-col shadow-2xl relative">
                        <h3 class="text-xs font-black uppercase text-[#10B981] tracking-widest border-b border-white/5 pb-3 mb-4">READY</h3>
                        
                        <div class="flex-1 overflow-y-auto space-y-2.5">
                            @php
                                $readyOrders = $orders->where('status', 'ready');
                            @endphp

                            @forelse($readyOrders as $ready)
                                <div class="flex items-center justify-between bg-white/5 border border-white/10 rounded-xl p-3 hover:bg-white/10 transition-colors">
                                    <div class="flex flex-col">
                                        <span class="text-xs font-bold">#{{ str_pad($ready->id, 4, '0', STR_PAD_LEFT) }}</span>
                                        <span class="text-[9px] text-[#10B981] font-bold mt-0.5">
                                            {{ $ready->order_type === 'takeaway' ? 'Takeaway' : 'Table ' . ($ready->table->table_number ?? 'N/A') }}
                                        </span>
                                    </div>
                                    <button wire:click="updateStatus({{ $ready->id }}, 'completed')" class="text-[#10B981] hover:text-emerald-400 active:scale-90 transition-all p-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </button>
                                </div>
                            @empty
                                <div class="h-full flex items-center justify-center text-center">
                                    <span class="text-xs font-bold text-slate-600">Empty</span>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<script>
    // Web Audio API - plays a pleasant "ding" notification sound
    function playNewOrderSound() {
        try {
            const ctx = new (window.AudioContext || window.webkitAudioContext)();

            const playTone = (freq, startTime, duration, gain = 0.4) => {
                const osc = ctx.createOscillator();
                const gainNode = ctx.createGain();
                osc.connect(gainNode);
                gainNode.connect(ctx.destination);
                osc.type = 'sine';
                osc.frequency.setValueAtTime(freq, startTime);
                gainNode.gain.setValueAtTime(gain, startTime);
                gainNode.gain.exponentialRampToValueAtTime(0.001, startTime + duration);
                osc.start(startTime);
                osc.stop(startTime + duration);
            };

            const now = ctx.currentTime;
            // 3-tone upward ding: C5 → E5 → G5
            playTone(523.25, now,        0.4);
            playTone(659.25, now + 0.18, 0.4);
            playTone(783.99, now + 0.36, 0.6);
        } catch (e) {
            console.warn('Audio notification failed:', e);
        }
    }

    // Listen for the Livewire event dispatched by KdsDashboard.php
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('new-order-sound', () => {
            playNewOrderSound();
        });
    });
</script>
