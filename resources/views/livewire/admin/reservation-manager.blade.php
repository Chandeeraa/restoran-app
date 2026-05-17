<div>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-slate-200">
            {{ __('Reservations Management') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="relative flex-1 max-w-md">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by name or phone..." class="w-full pl-10 pr-4 py-2 border border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-700/50 text-sm focus:ring-2 focus:ring-emerald-500 outline-none text-gray-700 dark:text-slate-200">
                </div>
                <div>
                    <select wire:model.live="statusFilter" class="px-4 py-2 border border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-700/50 text-sm focus:ring-2 focus:ring-emerald-500 outline-none text-gray-700 dark:text-slate-200 cursor-pointer">
                        <option value="">All Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 dark:bg-slate-700/30 border-b border-gray-100 dark:border-slate-700/50 text-xs uppercase tracking-wider text-gray-500 dark:text-slate-400">
                                <th class="p-4 font-semibold">Customer</th>
                                <th class="p-4 font-semibold">Date & Time</th>
                                <th class="p-4 font-semibold">Guests</th>
                                <th class="p-4 font-semibold">Status</th>
                                <th class="p-4 font-semibold text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-slate-700/50 text-sm">
                            @forelse($reservations as $res)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-700/20 transition-colors">
                                    <td class="p-4">
                                        <div class="font-bold text-gray-800 dark:text-slate-200">{{ $res->customer_name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-slate-400">{{ $res->customer_phone }}</div>
                                        @if($res->notes)
                                            <div class="text-[10px] text-orange-500 mt-1 italic max-w-xs truncate" title="{{ $res->notes }}">Note: {{ $res->notes }}</div>
                                        @endif
                                    </td>
                                    <td class="p-4">
                                        <div class="text-gray-800 dark:text-slate-200 font-medium">{{ \Carbon\Carbon::parse($res->reservation_date)->format('d M Y') }}</div>
                                        <div class="text-xs text-gray-500 dark:text-slate-400">{{ \Carbon\Carbon::parse($res->reservation_time)->format('H:i') }}</div>
                                    </td>
                                    <td class="p-4">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 font-bold text-xs">{{ $res->guest_count }}</span>
                                    </td>
                                    <td class="p-4">
                                        @php
                                            $badgeClasses = [
                                                'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                'confirmed' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                                'completed' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                                            ];
                                            $class = $badgeClasses[$res->status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                        @endphp
                                        <span class="px-2.5 py-1 text-[10px] font-bold uppercase rounded-full border {{ $class }}">
                                            {{ $res->status }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-right space-x-2">
                                        @if($res->status === 'pending')
                                            <button wire:click="updateStatus({{ $res->id }}, 'confirmed')" class="text-xs font-bold px-3 py-1.5 bg-emerald-50 text-emerald-600 hover:bg-emerald-100 rounded-lg transition-colors">Confirm</button>
                                            <button wire:click="updateStatus({{ $res->id }}, 'cancelled')" class="text-xs font-bold px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition-colors">Cancel</button>
                                        @elseif($res->status === 'confirmed')
                                            <button wire:click="updateStatus({{ $res->id }}, 'completed')" class="text-xs font-bold px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors">Complete</button>
                                            <button wire:click="updateStatus({{ $res->id }}, 'cancelled')" class="text-xs font-bold px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition-colors">Cancel</button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-gray-500 dark:text-slate-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-300 dark:text-slate-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <p>No reservations found matching your criteria.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($reservations->hasPages())
                    <div class="p-4 border-t border-gray-100 dark:border-slate-700/50">
                        {{ $reservations->links() }}
                    </div>
                @endif
            </div>
            
        </div>
    </div>
</div>
