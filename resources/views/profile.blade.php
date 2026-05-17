<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-slate-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Profile Photo Upload (Without Livewire) -->
            <div class="p-4 sm:p-8 bg-white dark:bg-slate-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                Profile Photo
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                Update your account's profile photo.
                            </p>
                        </header>

                        <form method="post" action="{{ route('profile.photo.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
                            @csrf
                            
                            <div class="flex items-center gap-6">
                                <div class="shrink-0">
                                    @if(auth()->user()->profile_photo_path)
                                        <img class="h-16 w-16 object-cover rounded-full border border-gray-200 dark:border-slate-700" src="{{ Storage::url(auth()->user()->profile_photo_path) }}" alt="Current profile photo" />
                                    @else
                                        <div class="h-16 w-16 rounded-full bg-gradient-to-tr from-emerald-500 to-purple-500 flex items-center justify-center text-white text-xl font-bold">
                                            {{ substr(auth()->user()->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                
                                <div>
                                    <label class="block">
                                        <span class="sr-only">Choose profile photo</span>
                                        <input type="file" name="photo" accept="image/*" class="block w-full text-sm text-gray-500 dark:text-slate-400
                                            file:mr-4 file:py-2 file:px-4
                                            file:rounded-md file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-emerald-50 file:text-emerald-700 dark:file:bg-emerald-900/30 dark:file:text-emerald-400
                                            hover:file:bg-emerald-100 dark:hover:file:bg-emerald-900/50
                                            cursor-pointer
                                        "/>
                                    </label>
                                    @error('photo', 'updateProfilePhoto')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    Save Photo
                                </button>

                                @if (session('status') === 'profile-photo-updated')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600 dark:text-gray-400"
                                    >Saved.</p>
                                @endif
                            </div>
                        </form>
                        
                        @if(auth()->user()->profile_photo_path)
                        <form method="post" action="{{ route('profile.photo.destroy') }}" class="mt-4">
                            @csrf
                            @method('delete')
                            <button type="submit" class="text-sm text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 underline">
                                Remove Photo
                            </button>
                        </form>
                        @endif
                    </section>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-slate-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-slate-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.update-password-form />
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-slate-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.delete-user-form />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
