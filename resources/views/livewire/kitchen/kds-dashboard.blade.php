<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight flex items-center gap-2">
                <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                Kitchen Display System
            </h2>
            <div class="flex items-center gap-2">
                <span class="relative flex h-3 w-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                </span>
                <span class="text-sm font-medium text-green-600">Live</span>
            </div>
        </div>

        @if($orders->isEmpty())
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                <h3 class="text-lg font-medium text-gray-900">No active orders</h3>
                <p class="text-gray-500 mt-1">Waiting for new orders to arrive...</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($orders as $order)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col relative"
                         wire:key="order-{{ $order->id }}"
                         x-data="{ showItems: true }"
                         class="transition-all duration-300 transform hover:-translate-y-1 hover:shadow-md">
                        
                        <!-- Top status line indicator -->
                        <div class="h-1 w-full {{ $order->status === 'pending' ? 'bg-orange-400' : 'bg-blue-500' }}"></div>

                        <div class="p-4 border-b border-gray-50 bg-gray-50/50">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    <h3 class="text-lg font-bold text-gray-900 leading-tight mt-0.5">
                                        {{ $order->order_type === 'dine-in' ? 'Meja ' . ($order->table->table_number ?? 'N/A') : 'Takeaway' }}
                                    </h3>
                                    @if($order->customer_name)
                                        <p class="text-xs font-semibold text-indigo-600 mt-0.5">👤 {{ $order->customer_name }}</p>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium {{ $order->status === 'pending' ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ $order->status === 'cooking' ? 'Cooking' : ucfirst($order->status) }}
                                    </span>
                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $order->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                            
                            @if($order->customer_name)
                            <div class="text-sm text-gray-600 flex items-center gap-1.5 mt-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                {{ $order->customer_name }}
                            </div>
                            @endif
                        </div>

                        <div class="p-4 flex-1 overflow-y-auto">
                            <ul class="space-y-3">
                                @foreach($order->items as $item)
                                    <li class="flex items-start gap-3">
                                        <div class="flex-shrink-0 mt-0.5">
                                            <span class="inline-flex items-center justify-center h-6 w-6 rounded-md bg-gray-100 text-sm font-bold text-gray-700 border border-gray-200">
                                                {{ $item->quantity }}
                                            </span>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">{{ $item->menu->name ?? 'Unknown Menu' }}</p>
                                            @if($item->notes)
                                                <p class="text-xs text-red-600 mt-0.5 bg-red-50 p-1 rounded border border-red-100 inline-block">
                                                    Note: {{ $item->notes }}
                                                </p>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="p-4 border-t border-gray-100 bg-gray-50">
                            @if($order->status === 'pending')
                                <button wire:click="updateStatus({{ $order->id }}, 'cooking')" 
                                        class="w-full flex justify-center items-center gap-2 px-4 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Start Cooking
                                </button>
                            @elseif($order->status === 'cooking')
                                <button wire:click="updateStatus({{ $order->id }}, 'ready')" 
                                        class="w-full flex justify-center items-center gap-2 px-4 py-2.5 bg-green-500 text-white rounded-xl text-sm font-semibold hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Mark as Ready
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
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
