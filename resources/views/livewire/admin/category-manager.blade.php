<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-slate-200 leading-tight">
            {{ __('Manajemen Kategori') }}
        </h2>
    </x-slot>

    <div class="flex flex-col md:flex-row gap-6">
        <!-- Form Section -->
        <div class="w-full md:w-1/3">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-slate-100 mb-4">{{ $isEditMode ? 'Edit Kategori' : 'Tambah Kategori' }}</h3>
                
                @if (session()->has('message'))
                    <div class="mb-4 p-3 rounded-lg bg-green-50 text-green-700 text-sm">
                        {{ session('message') }}
                    </div>
                @endif

                <form wire:submit.prevent="{{ $isEditMode ? 'update' : 'store' }}">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">Nama Kategori</label>
                        <input type="text" wire:model.live="name" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">Slug</label>
                        <input type="text" wire:model="slug" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm bg-gray-50 dark:bg-slate-800/50" readonly>
                        @error('slug') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4 flex items-center gap-4">
                        <div class="flex items-center">
                            <input type="checkbox" wire:model="is_active" id="cat_is_active" class="rounded border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 text-emerald-600 shadow-sm">
                            <label for="cat_is_active" class="ml-2 block text-sm text-gray-900 dark:text-slate-100">Aktif</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" wire:model="is_drink" id="cat_is_drink" class="rounded border-gray-300 dark:border-slate-700 dark:bg-slate-900 text-green-500 shadow-sm">
                            <label for="cat_is_drink" class="ml-2 block text-sm text-gray-900 dark:text-slate-100">🧃 Kategori Minuman</label>
                        </div>
                    </div>
                    <p class="text-xs text-green-500 dark:text-green-400 -mt-2 mb-5">* Minuman dianggap langsung siap (tidak perlu proses masak).</p>

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
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Nama Kategori</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                        @forelse ($categories as $category)
                            <tr class="hover:bg-gray-50 dark:bg-slate-800/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-slate-100">{{ $category->name }}</div>
                                    <div class="text-sm text-gray-500 dark:text-slate-400">{{ $category->slug }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 dark:bg-slate-700 text-gray-800 dark:text-slate-200' }}">
                                        {{ $category->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                    @if($category->is_drink)
                                        <span class="ml-1 px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-700">
                                            🧃 Minuman
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button wire:click="edit({{ $category->id }})" class="text-emerald-600 hover:text-emerald-900 mr-3 transition-colors">Edit</button>
                                    <button wire:click="delete({{ $category->id }})" wire:confirm="Apakah Anda yakin?" class="text-red-600 hover:text-red-900 transition-colors">Hapus</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-500 dark:text-slate-400">
                                    Kategori tidak ditemukan. Silakan tambahkan kategori baru!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @if($categories->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
