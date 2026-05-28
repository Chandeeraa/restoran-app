<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-slate-200 leading-tight">
            {{ __('Manajemen Menu') }}
        </h2>
    </x-slot>

    {{-- Low Stock Alert Banner --}}
    @if(isset($lowStockMenus) && $lowStockMenus->count() > 0)
    <div class="mb-6 bg-amber-50 border border-amber-200 rounded-2xl p-4">
        <div class="flex items-center gap-2 mb-2">
            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <span class="font-semibold text-amber-800">⚠️ Stok Menipis! ({{ $lowStockMenus->count() }} item)</span>
        </div>
        <div class="flex flex-wrap gap-2">
            @foreach($lowStockMenus as $lm)
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-semibold">
                {{ $lm->name }}: <strong>{{ $lm->stock }} sisa</strong>
            </span>
            @endforeach
        </div>
    </div>
    @endif

    <div class="flex flex-col md:flex-row gap-6">
        <!-- Form Section -->
        <div class="w-full md:w-1/3">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6 sticky top-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-slate-100 mb-4">{{ $isEditMode ? 'Edit Menu' : 'Create Menu' }}</h3>
                
                @if (session()->has('message'))
                    <div class="mb-4 p-3 rounded-lg bg-green-50 text-green-700 text-sm">
                        {{ session('message') }}
                    </div>
                @endif

                <form wire:submit.prevent="{{ $isEditMode ? 'update' : 'store' }}">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">Nama Menu</label>
                        <input type="text" wire:model="name" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">Kategori</label>
                        <select wire:model="category_id" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm {{ $categories->isEmpty() ? 'bg-gray-100 dark:bg-slate-700 cursor-not-allowed' : '' }}" {{ $categories->isEmpty() ? 'disabled' : '' }}>
                            @if($categories->isEmpty())
                                <option value="">Kategori tidak tersedia - Silakan buat kategori dulu</option>
                            @else
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('category_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">Harga (Rp)</label>
                        <input type="number" wire:model="price" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                        @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">Deskripsi</label>
                        <textarea wire:model="description" rows="3" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm"></textarea>
                        @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">Foto Menu</label>
                        <input type="file" wire:model="image" class="mt-1 block w-full text-sm text-gray-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                        @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        
                        <div wire:loading wire:target="image" class="text-sm text-gray-500 dark:text-slate-400 mt-2">Mengunggah...</div>
                        
                        @if ($image)
                            <div class="mt-2">
                                <img src="{{ $image->temporaryUrl() }}" class="h-20 w-20 object-cover rounded-lg">
                            </div>
                        @elseif ($existingImage)
                            <div class="mt-2">
                                <img src="{{ Storage::url($existingImage) }}" class="h-20 w-20 object-cover rounded-lg">
                            </div>
                        @endif
                    </div>

                    <div class="mb-6 flex items-center space-x-6">
                        <div class="flex items-center">
                            <input type="checkbox" wire:model.live="track_stock" id="track_stock" class="rounded border-gray-300 dark:border-slate-700 dark:bg-slate-900 text-emerald-600 shadow-sm">
                            <label for="track_stock" class="ml-2 block text-sm text-gray-900 dark:text-slate-100">Kelola Stok</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" wire:model="is_available" id="is_available" class="rounded border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 text-emerald-600 shadow-sm">
                            <label for="is_available" class="ml-2 block text-sm text-gray-900 dark:text-slate-100">Tersedia</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" wire:model="is_best_seller" id="is_best_seller" class="rounded border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 text-orange-500 shadow-sm">
                            <label for="is_best_seller" class="ml-2 block text-sm text-gray-900 dark:text-slate-100">Best Seller</label>
                        </div>
                    </div>

                    @if($track_stock)
                    <div class="mb-4 grid grid-cols-2 gap-3 p-4 bg-emerald-50 dark:bg-slate-700/30 rounded-xl border border-emerald-100 dark:border-slate-700">
                        <div>
                            <label class="block text-xs font-semibold text-emerald-700 dark:text-emerald-300 mb-1">Jumlah Stok Saat Ini</label>
                            <input type="number" wire:model="stock" min="0" class="block w-full rounded-lg border-emerald-200 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-300 shadow-sm text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-amber-700 dark:text-amber-400 mb-1">Alert Jika Stok ≤</label>
                            <input type="number" wire:model="low_stock_threshold" min="1" class="block w-full rounded-lg border-amber-200 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-300 shadow-sm text-sm">
                        </div>
                        <p class="col-span-2 text-xs text-emerald-500 dark:text-emerald-400">* Menu akan otomatis dinonaktifkan saat stok mencapai 0.</p>
                    </div>
                    @endif

                    <div class="flex items-center gap-3">
                        <button type="submit" class="inline-flex justify-center rounded-xl border border-transparent bg-emerald-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-all">
                            {{ $isEditMode ? 'Simpan Perubahan' : 'Simpan' }}
                        </button>
                        
                        @if($isEditMode)
                            <button type="button" wire:click="resetFields" class="inline-flex justify-center rounded-xl border border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 bg-white dark:bg-slate-800 py-2 px-4 text-sm font-medium text-gray-700 dark:text-slate-300 shadow-sm hover:bg-gray-50 dark:bg-slate-800/50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-all">
                                Batal
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
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Menu</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Harga</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Stok</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                        @forelse ($menus as $menu)
                            <tr class="hover:bg-gray-50 dark:bg-slate-800/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-12 w-12 flex-shrink-0">
                                            @if($menu->image)
                                                <img class="h-12 w-12 rounded-lg object-cover" src="{{ Storage::url($menu->image) }}" alt="">
                                            @else
                                                <div class="h-12 w-12 rounded-lg bg-gray-200 flex items-center justify-center">
                                                    <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-slate-100 flex items-center gap-2">
                                                {{ $menu->name }}
                                                @if($menu->is_best_seller)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-500/20 dark:text-orange-400">
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                                        Best Seller
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-slate-400">{{ $menu->category?->name ?? 'Uncategorized' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-slate-100">Rp {{ number_format($menu->price, 0, ',', '.') }}</div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    @if($menu->track_stock)
                                        @if($editingStockId === $menu->id)
                                            {{-- Inline Editor Aktif --}}
                                            <div class="flex items-center gap-1">
                                                <input type="number" wire:model="quickStockValue" min="0"
                                                    class="w-16 text-sm rounded-lg border-emerald-300 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 py-1 px-2 text-center"
                                                    wire:keydown.enter="saveStock({{ $menu->id }})"
                                                    wire:keydown.escape="cancelStockEdit">
                                                <button wire:click="saveStock({{ $menu->id }})" class="p-1 text-green-600 hover:text-green-800">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                </button>
                                                <button wire:click="cancelStockEdit" class="p-1 text-gray-400 hover:text-gray-600">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            </div>
                                        @else
                                            {{-- Tampilan Normal --}}
                                            <button wire:click="openStockEdit({{ $menu->id }})" class="group flex items-center gap-1.5"
                                                title="Klik untuk edit stok">
                                                @if($menu->isOutOfStock())
                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-red-100 text-red-700 text-xs font-bold">📦 Habis</span>
                                                @elseif($menu->isLowStock())
                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 text-xs font-bold">⚠️ {{ $menu->stock }}</span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-green-100 text-green-700 text-xs font-bold">✅ {{ $menu->stock }}</span>
                                                @endif
                                                <svg class="w-3 h-3 text-gray-400 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </button>
                                        @endif
                                    @else
                                        <span class="text-xs text-gray-400 dark:text-slate-500 italic">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button wire:click="toggleAvailability({{ $menu->id }})" title="Klik untuk ubah status"
                                        class="group inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold transition-all {{ $menu->is_available ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $menu->is_available ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                        {{ $menu->is_available ? 'Tersedia' : 'Habis' }}
                                    </button>
                                    <button wire:click="toggleBestSeller({{ $menu->id }})" title="Toggle Best Seller"
                                        class="ml-2 inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold transition-all {{ $menu->is_best_seller ? 'bg-orange-100 text-orange-800 hover:bg-orange-200' : 'bg-gray-100 text-gray-500 hover:bg-gray-200 dark:bg-slate-700 dark:text-slate-400' }}">
                                        ⭐
                                    </button>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button wire:click="edit({{ $menu->id }})" class="text-emerald-600 hover:text-emerald-900 mr-3 transition-colors">Edit</button>
                                    <button wire:click="delete({{ $menu->id }})" wire:confirm="Apakah Anda yakin?" class="text-red-600 hover:text-red-900 transition-colors">Hapus</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-slate-400">
                                    Menu tidak ditemukan. Silakan tambahkan menu baru!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @if($menus->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50">
                        {{ $menus->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
