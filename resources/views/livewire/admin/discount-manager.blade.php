<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-slate-200 leading-tight">Discount Manager</h2>
    </x-slot>

    <div class="flex flex-col md:flex-row gap-6">
        <!-- Form -->
        <div class="w-full md:w-1/3">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6 sticky top-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-slate-100 mb-4">
                    {{ $isEditMode ? 'Edit Kode Diskon' : 'Buat Kode Diskon Baru' }}
                </h3>

                @if (session()->has('message'))
                    <div class="mb-4 p-3 rounded-lg bg-green-50 text-green-700 text-sm border border-green-200">
                        {{ session('message') }}
                    </div>
                @endif

                <form wire:submit.prevent="{{ $isEditMode ? 'update' : 'store' }}">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">Kode Promo</label>
                            <input type="text" wire:model="code" placeholder="PROMO10" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm uppercase" style="text-transform:uppercase">
                            @error('code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">Deskripsi (Opsional)</label>
                            <input type="text" wire:model="description" placeholder="Diskon 10% untuk pelanggan baru" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">Tipe</label>
                                <select wire:model.live="type" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="percentage">Persentase (%)</option>
                                    <option value="fixed">Nominal Tetap (Rp)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">Nilai {{ $type === 'percentage' ? '(%)' : '(Rp)' }}</label>
                                <input type="number" wire:model="value" placeholder="{{ $type === 'percentage' ? '10' : '50000' }}" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('value') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">Batas Penggunaan (kosongkan = tak terbatas)</label>
                            <input type="number" wire:model="max_uses" placeholder="100" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" wire:model="is_active" class="rounded border-gray-300 text-indigo-600">
                            <label class="ml-2 text-sm text-gray-700 dark:text-slate-300">Aktif</label>
                        </div>
                    </div>

                    <div class="mt-5 flex items-center gap-3">
                        <button type="submit" class="inline-flex justify-center rounded-xl border border-transparent bg-indigo-600 py-2 px-5 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 transition-all">
                            {{ $isEditMode ? 'Update' : 'Buat Kode' }}
                        </button>
                        @if($isEditMode)
                            <button type="button" wire:click="resetFields" class="inline-flex justify-center rounded-xl border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 py-2 px-4 text-sm font-medium text-gray-700 dark:text-slate-300 shadow-sm hover:bg-gray-50 transition-all">
                                Batal
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Discount Table -->
        <div class="w-full md:w-2/3">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                    <thead class="bg-gray-50 dark:bg-slate-800/50">
                        <tr>
                            <th class="px-5 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase">Kode</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase">Nilai</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase">Penggunaan</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase">Status</th>
                            <th class="px-5 py-4 text-right text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                        @forelse($discounts as $discount)
                        <tr wire:key="discount-{{ $discount->id }}" class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-5 py-4">
                                <div class="font-mono font-bold text-gray-900 dark:text-slate-100 text-sm tracking-wider">{{ $discount->code }}</div>
                                @if($discount->description)
                                    <div class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">{{ $discount->description }}</div>
                                @endif
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                @if($discount->type === 'percentage')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                        {{ $discount->value }}%
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-800">
                                        Rp {{ number_format($discount->value, 0, ',', '.') }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-slate-400">
                                {{ $discount->used_count }} / {{ $discount->max_uses ?? '∞' }}
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                <button wire:click="toggleActive({{ $discount->id }})"
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold transition-all {{ $discount->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-gray-100 text-gray-500 hover:bg-gray-200 dark:bg-slate-700 dark:text-slate-400' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $discount->is_active ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                                    {{ $discount->is_active ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="edit({{ $discount->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3 transition-colors">Edit</button>
                                <button wire:click="delete({{ $discount->id }})" wire:confirm="Hapus kode {{ $discount->code }}?" class="text-red-600 hover:text-red-900 transition-colors">Hapus</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400 dark:text-slate-500">
                                Belum ada kode diskon. Buat yang pertama!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
