<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-slate-200 leading-tight">
            {{ __('Store Settings') }}
        </h2>
    </x-slot>

    <div class="flex flex-col md:flex-row gap-6">
        <!-- Settings Form -->
        <div class="w-full md:w-1/2">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-slate-100 mb-4">General Configuration</h3>
                
                @if (session()->has('message'))
                    <div class="mb-4 p-3 rounded-lg bg-green-50 text-green-700 text-sm border border-green-200">
                        {{ session('message') }}
                    </div>
                @endif

                <form wire:submit.prevent="save">
                    <div class="space-y-4">
                        <!-- Store Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">Store Name</label>
                            <input type="text" wire:model="store_name" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('store_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Store Address -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">Store Address</label>
                            <textarea wire:model="store_address" rows="3" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                            @error('store_address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Store Phone -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">Phone Number</label>
                            <input type="text" wire:model="store_phone" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('store_phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="border-t border-gray-200 dark:border-slate-700 pt-4 mt-6">
                            <h4 class="text-md font-medium text-gray-900 dark:text-slate-100 mb-4">Taxes & Fees</h4>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <!-- Tax Rate -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">Tax / PPN (%)</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input type="number" step="0.01" wire:model="tax_rate" class="block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 pr-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                            <span class="text-gray-500 sm:text-sm">%</span>
                                        </div>
                                    </div>
                                    @error('tax_rate') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <!-- Service Charge Rate -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">Service Charge (%)</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input type="number" step="0.01" wire:model="service_charge_rate" class="block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 pr-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                            <span class="text-gray-500 sm:text-sm">%</span>
                                        </div>
                                    </div>
                                    @error('service_charge_rate') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-gray-500 dark:text-slate-400">These percentages will be automatically calculated during checkout.</p>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="inline-flex justify-center rounded-xl border border-transparent bg-indigo-600 py-2 px-6 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all">
                            Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info / Preview -->
        <div class="w-full md:w-1/2">
            <div class="bg-gray-50 dark:bg-slate-800/50 rounded-2xl border border-gray-200 dark:border-slate-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-slate-100 mb-4">Receipt Preview</h3>
                
                <div class="bg-white dark:bg-slate-900 p-6 rounded-lg shadow-sm font-mono text-sm border border-gray-200 dark:border-slate-700 max-w-sm mx-auto">
                    <div class="text-center mb-4 border-b border-dashed border-gray-300 pb-4">
                        <h2 class="font-bold text-lg mb-1">{{ $store_name ?: 'Your Store Name' }}</h2>
                        <div class="text-gray-600 dark:text-gray-400">{{ $store_address ?: 'Your Store Address' }}</div>
                        <div class="text-gray-600 dark:text-gray-400">Tel: {{ $store_phone ?: '-' }}</div>
                    </div>

                    <div class="space-y-1 text-gray-600 dark:text-gray-400 border-b border-dashed border-gray-300 pb-4 mb-4">
                        <div class="flex justify-between">
                            <span>1x Example Menu</span>
                            <span>100,000</span>
                        </div>
                    </div>

                    <div class="space-y-1 font-bold">
                        <div class="flex justify-between text-gray-600 dark:text-gray-400 font-normal">
                            <span>Subtotal</span>
                            <span>100,000</span>
                        </div>
                        @if($tax_rate > 0)
                        <div class="flex justify-between text-gray-600 dark:text-gray-400 font-normal">
                            <span>Tax ({{ $tax_rate }}%)</span>
                            <span>{{ number_format(100000 * ($tax_rate/100)) }}</span>
                        </div>
                        @endif
                        @if($service_charge_rate > 0)
                        <div class="flex justify-between text-gray-600 dark:text-gray-400 font-normal">
                            <span>Service Chg ({{ $service_charge_rate }}%)</span>
                            <span>{{ number_format(100000 * ($service_charge_rate/100)) }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between text-lg mt-2 pt-2 border-t border-gray-200 dark:border-slate-700">
                            <span>TOTAL</span>
                            <span>{{ number_format(100000 + (100000 * ($tax_rate/100)) + (100000 * ($service_charge_rate/100))) }}</span>
                        </div>
                    </div>
                    
                    <div class="text-center mt-6 text-gray-500 text-xs">
                        Thank you for your visit!
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
