<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Table Management') }}
        </h2>
    </x-slot>

    <div class="flex flex-col md:flex-row gap-6">
        <!-- Form Section -->
        <div class="w-full md:w-1/3">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ $isEditMode ? 'Edit Table' : 'Create Table' }}</h3>
                
                @if (session()->has('message'))
                    <div class="mb-4 p-3 rounded-lg bg-green-50 text-green-700 text-sm">
                        {{ session('message') }}
                    </div>
                @endif

                <form wire:submit.prevent="{{ $isEditMode ? 'update' : 'store' }}">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Table Number</label>
                        <input type="text" wire:model="table_number" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="e.g. T-01">
                        @error('table_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select wire:model="status" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="available">Available</option>
                            <option value="occupied">Occupied</option>
                        </select>
                        @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit" class="inline-flex justify-center rounded-xl border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all">
                            {{ $isEditMode ? 'Update' : 'Save & Generate QR' }}
                        </button>
                        
                        @if($isEditMode)
                            <button type="button" wire:click="resetFields" class="inline-flex justify-center rounded-xl border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all">
                                Cancel
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Table Section -->
        <div class="w-full md:w-2/3">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Table Number</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">QR Code</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($tables as $table)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $table->table_number }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($table->qr_code)
                                        <div class="h-16 w-16 bg-white p-1 border rounded shadow-sm">
                                            {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(50)->generate($table->qr_code) !!}
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-xs">No QR</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $table->status === 'available' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                                        {{ ucfirst($table->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button wire:click="edit({{ $table->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3 transition-colors">Edit</button>
                                    <button wire:click="delete({{ $table->id }})" wire:confirm="Are you sure?" class="text-red-600 hover:text-red-900 transition-colors">Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                    No tables found. Create a new one!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @if($tables->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50/50">
                        {{ $tables->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
