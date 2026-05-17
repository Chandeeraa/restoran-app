<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-slate-200 leading-tight">
            {{ __('Table Management') }}
        </h2>
    </x-slot>

    <div class="flex flex-col md:flex-row gap-6">
        <!-- Form Section -->
        <div class="w-full md:w-1/3">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6 sticky top-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-slate-100 mb-4">{{ $isEditMode ? 'Edit Table' : 'Create Table' }}</h3>
                
                @if (session()->has('message'))
                    <div class="mb-4 p-3 rounded-lg bg-green-50 text-green-700 text-sm">
                        {{ session('message') }}
                    </div>
                @endif

                <form wire:submit.prevent="{{ $isEditMode ? 'update' : 'store' }}">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">Table Number</label>
                        <input type="text" wire:model="table_number" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm" placeholder="e.g. T-01">
                        @error('table_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">Status</label>
                        <select wire:model="status" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                            <option value="available">Available</option>
                            <option value="occupied">Occupied</option>
                        </select>
                        @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit" class="inline-flex justify-center rounded-xl border border-transparent bg-emerald-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-all">
                            {{ $isEditMode ? 'Update' : 'Save & Generate QR' }}
                        </button>
                        
                        @if($isEditMode)
                            <button type="button" wire:click="resetFields" class="inline-flex justify-center rounded-xl border border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 bg-white dark:bg-slate-800 py-2 px-4 text-sm font-medium text-gray-700 dark:text-slate-300 shadow-sm hover:bg-gray-50 dark:bg-slate-800/50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-all">
                                Cancel
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Table Section -->
        <div class="w-full md:w-2/3">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                    <thead class="bg-gray-50 dark:bg-slate-800/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Table Number</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">QR Code</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                        @forelse ($tables as $table)
                            <tr class="hover:bg-gray-50 dark:bg-slate-800/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-slate-100">{{ $table->table_number }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($table->qr_code)
                                        <button wire:click="openQrModal({{ $table->id }})" class="group relative">
                                            <div class="h-16 w-16 bg-white dark:bg-slate-800 p-1 border rounded shadow-sm group-hover:border-emerald-300 transition-all">
                                                {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(50)->generate($table->qr_code) !!}
                                            </div>
                                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 bg-black/5 rounded transition-opacity">
                                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                            </div>
                                        </button>
                                    @else
                                        <span class="text-gray-400 text-xs">No QR</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button wire:click="toggleStatus({{ $table->id }})" title="Klik untuk ubah status"
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold transition-all {{ $table->status === 'available' ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-orange-100 text-orange-800 hover:bg-orange-200' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $table->status === 'available' ? 'bg-green-500' : 'bg-orange-500' }}"></span>
                                        {{ $table->status === 'available' ? 'Kosong' : 'Terisi' }}
                                    </button>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button wire:click="edit({{ $table->id }})" class="text-emerald-600 hover:text-emerald-900 mr-3 transition-colors">Edit</button>
                                    <button wire:click="delete({{ $table->id }})" wire:confirm="Are you sure?" class="text-red-600 hover:text-red-900 transition-colors">Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-slate-400">
                                    No tables found. Create a new one!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @if($tables->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50">
                        {{ $tables->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- QR Modal -->
    @if($showQrModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-50 dark:bg-slate-800/500 bg-opacity-75 transition-opacity" wire:click="closeQrModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white dark:bg-slate-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full">
                    <div class="bg-white dark:bg-slate-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4 text-center">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-slate-100 mb-2">QR Code Meja {{ $selectedTableNumber }}</h3>
                        <p class="text-sm text-gray-500 dark:text-slate-400 mb-6">Scan QR ini untuk langsung memesan di meja ini.</p>
                        
                        <div class="flex justify-center mb-6">
                            <div class="p-4 bg-white dark:bg-slate-800 border-4 border-emerald-50 rounded-3xl shadow-inner">
                                {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(250)->margin(1)->generate($selectedTableQr) !!}
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <button onclick="window.print()" class="flex-1 inline-flex justify-center rounded-xl border border-transparent bg-emerald-600 py-2.5 px-4 text-sm font-bold text-white shadow-sm hover:bg-emerald-700 transition-all">
                                Print QR
                            </button>
                            <button wire:click="closeQrModal" class="flex-1 inline-flex justify-center rounded-xl border border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 bg-white dark:bg-slate-800 py-2.5 px-4 text-sm font-bold text-gray-700 dark:text-slate-300 shadow-sm hover:bg-gray-50 dark:bg-slate-800/50 transition-all">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

