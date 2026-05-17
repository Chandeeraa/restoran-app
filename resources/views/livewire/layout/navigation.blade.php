<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="bg-brand-cream dark:bg-emerald-950 md:bg-transparent md:dark:bg-transparent h-full flex flex-col border-b md:border-b-0 border-gray-100 dark:border-slate-700/50/50 dark:border-slate-700/50">
    <!-- Mobile Header -->
    <div class="md:hidden flex justify-between items-center h-16 px-4 sm:px-6">
        <!-- Logo -->
        <div class="shrink-0 flex items-center">
            <a href="{{ route('dashboard') }}" wire:navigate.hover class="flex items-center gap-2">
                <i class="fa-solid fa-mug-hot text-[#5c3a21] dark:text-amber-500 text-2xl drop-shadow-sm"></i>
                <span class="font-serif font-bold text-lg tracking-widest text-[#5c3a21] dark:text-amber-400 mt-1">YON RESTO</span>
            </a>
        </div>

        <!-- Hamburger & Dark Mode -->
        <div class="-me-2 flex items-center gap-1">
            <!-- Dark Mode Toggle -->
            <button @click="darkMode = !darkMode" class="p-2 rounded-md text-gray-400 hover:text-gray-500 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-slate-800 focus:outline-none transition-colors">
                <svg x-show="darkMode" x-cloak class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <svg x-show="!darkMode" x-cloak class="w-5 h-5 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
            </button>

            <!-- Hamburger -->
            <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-slate-800 focus:outline-none transition duration-150 ease-in-out">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Desktop Sidebar & Mobile Dropdown Content -->
    <div :class="{'block': open, 'hidden': ! open}" class="md:flex md:flex-col md:flex-1 absolute md:static top-16 left-0 w-full md:w-auto h-auto md:h-full max-h-[calc(100vh-4rem)] md:max-h-none overflow-y-auto md:overflow-y-visible bg-brand-cream dark:bg-emerald-950 md:bg-transparent md:dark:bg-transparent border-b border-gray-200 dark:border-slate-700 md:border-none shadow-xl md:shadow-none z-50 md:z-0">
        
        <!-- Sidebar Decorative Blobs (Bercampur / Bulatan) -->
        <div class="absolute inset-0 z-[-1] overflow-hidden pointer-events-none hidden md:block">
            <!-- Light mode blobs -->
            <div class="absolute -top-12 -left-12 w-40 h-40 bg-brand-yellow/40 rounded-full blur-2xl dark:hidden"></div>
            <div class="absolute top-[40%] -right-12 w-32 h-32 bg-brand-green/30 rounded-full blur-2xl dark:hidden"></div>
            <div class="absolute bottom-[10%] -left-10 w-48 h-48 bg-brand-orange/30 rounded-full blur-3xl dark:hidden"></div>
            
            <!-- Dark mode blobs -->
            <div class="absolute -top-12 -left-12 w-40 h-40 bg-teal-500/30 rounded-full blur-2xl hidden dark:block"></div>
            <div class="absolute top-[30%] -right-12 w-32 h-32 bg-amber-500/30 rounded-full blur-2xl hidden dark:block"></div>
            <div class="absolute bottom-[20%] -left-10 w-48 h-48 bg-emerald-500/20 rounded-full blur-3xl hidden dark:block"></div>
        </div>
        <!-- Desktop Logo & Profile -->
        <div class="hidden md:flex flex-col items-center pt-8 pb-6 px-4 border-b border-gray-100 dark:border-slate-700/50">
            <a href="{{ route('dashboard') }}" wire:navigate class="mb-6 w-full flex justify-center">
                <x-application-logo class="h-20" />
            </a>
            
            @if(auth()->user()->profile_photo_path)
                <img src="{{ Storage::url(auth()->user()->profile_photo_path) }}" alt="{{ auth()->user()->name }}" class="w-16 h-16 rounded-full object-cover border border-gray-200 dark:border-slate-700 shadow-md mb-3">
            @else
                <div class="w-16 h-16 rounded-full bg-gradient-to-tr from-emerald-500 to-purple-500 flex items-center justify-center text-white text-xl font-bold shadow-md mb-3">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            @endif
            
            <div class="font-semibold text-gray-800 dark:text-slate-200 text-center" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
            
            <!-- Role Badge -->
            <div class="mt-2">
                @php
                    $role = auth()->user()->role;
                    $roleLabel = 'User';
                    $badgeColor = 'bg-gray-100 text-gray-800 dark:text-slate-200 border-gray-200 dark:border-slate-700';
                    
                    if ($role === 'admin') {
                        $roleLabel = 'Admin (Master)';
                        $badgeColor = 'bg-red-50 text-red-700 border-red-200';
                    } elseif ($role === 'cashier') {
                        $roleLabel = 'Kasir';
                        $badgeColor = 'bg-green-50 text-green-700 border-green-200';
                    } elseif ($role === 'kitchen') {
                        $roleLabel = 'Dapur';
                        $badgeColor = 'bg-orange-50 text-orange-700 border-orange-200';
                    } elseif ($role === 'customer' || $role === 'waiter') {
                        $roleLabel = 'Pelayan';
                        $badgeColor = 'bg-green-50 text-green-700 border-green-200';
                    }
                @endphp
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $badgeColor }}">
                    {{ $roleLabel }}
                </span>
            </div>
        </div>

        <!-- Navigation Links -->
        <div class="flex-1 py-6 px-4 space-y-1">
            <!-- Dashboard (Everyone) -->
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex w-full px-3 py-2 rounded-lg mb-1 {{ request()->routeIs('dashboard') ? 'bg-brand-yellow/20 dark:bg-brand-yellow/20 text-yellow-700 dark:text-brand-yellow' : 'text-gray-600 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700/50' }}" wire:navigate.hover>
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('dashboard') ? 'text-brand-orange' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                {{ __('Dashboard') }}
            </x-nav-link>

            <!-- Admin Only -->
            @if(auth()->user()->role === 'admin')
                <div class="pt-4 pb-2">
                    <p class="px-3 text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-wider">Management</p>
                </div>
                <x-nav-link :href="route('admin.stats')" :active="request()->routeIs('admin.stats')" class="flex w-full px-3 py-2 rounded-lg mb-1 {{ request()->routeIs('admin.stats') ? 'bg-brand-yellow/20 dark:bg-brand-yellow/20 text-yellow-700 dark:text-brand-yellow' : 'text-gray-600 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700/50' }}" wire:navigate.hover>
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.stats') ? 'text-brand-orange' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Statistics
                </x-nav-link>
                <x-nav-link :href="route('admin.users')" :active="request()->routeIs('admin.users')" class="flex w-full px-3 py-2 rounded-lg mb-1 {{ request()->routeIs('admin.users') ? 'bg-brand-yellow/20 dark:bg-brand-yellow/20 text-yellow-700 dark:text-brand-yellow' : 'text-gray-600 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700/50' }}" wire:navigate.hover>
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.users') ? 'text-brand-orange' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Staff & Users
                </x-nav-link>
                <x-nav-link :href="route('admin.settings')" :active="request()->routeIs('admin.settings')" class="flex w-full px-3 py-2 rounded-lg mb-1 {{ request()->routeIs('admin.settings') ? 'bg-brand-yellow/20 dark:bg-brand-yellow/20 text-yellow-700 dark:text-brand-yellow' : 'text-gray-600 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700/50' }}" wire:navigate.hover>
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.settings') ? 'text-brand-orange' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Store Settings
                </x-nav-link>
                <x-nav-link :href="route('admin.discounts')" :active="request()->routeIs('admin.discounts')" class="flex w-full px-3 py-2 rounded-lg mb-1 {{ request()->routeIs('admin.discounts') ? 'bg-brand-yellow/20 dark:bg-brand-yellow/20 text-yellow-700 dark:text-brand-yellow' : 'text-gray-600 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700/50' }}" wire:navigate.hover>
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.discounts') ? 'text-brand-orange' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    Discounts & Promo
                </x-nav-link>
                <x-nav-link :href="route('admin.categories')" :active="request()->routeIs('admin.categories')" class="flex w-full px-3 py-2 rounded-lg mb-1 {{ request()->routeIs('admin.categories') ? 'bg-brand-yellow/20 dark:bg-brand-yellow/20 text-yellow-700 dark:text-brand-yellow' : 'text-gray-600 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700/50' }}" wire:navigate.hover>
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.categories') ? 'text-brand-orange' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    Categories
                </x-nav-link>
                <x-nav-link :href="route('admin.menus')" :active="request()->routeIs('admin.menus')" class="flex w-full px-3 py-2 rounded-lg mb-1 {{ request()->routeIs('admin.menus') ? 'bg-brand-yellow/20 dark:bg-brand-yellow/20 text-yellow-700 dark:text-brand-yellow' : 'text-gray-600 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700/50' }}" wire:navigate.hover>
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.menus') ? 'text-brand-orange' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                    Menus
                </x-nav-link>
            @endif

            <!-- Admin, Customer/Waiter -->
            @if(in_array(auth()->user()->role, ['admin', 'customer', 'waiter']))
                <div class="pt-4 pb-2">
                    <p class="px-3 text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-wider">Service</p>
                </div>
                <x-nav-link :href="route('order')" :active="request()->routeIs('order')" class="flex w-full px-3 py-2 rounded-lg mb-1 {{ request()->routeIs('order') ? 'bg-brand-yellow/20 dark:bg-brand-yellow/20 text-yellow-700 dark:text-brand-yellow' : 'text-gray-600 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700/50' }}" wire:navigate.hover>
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('order') ? 'text-brand-orange' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Order Page
                </x-nav-link>
                @if(auth()->user()->role === 'admin')
                    <x-nav-link :href="route('admin.tables')" :active="request()->routeIs('admin.tables')" class="flex w-full px-3 py-2 rounded-lg mb-1 {{ request()->routeIs('admin.tables') ? 'bg-brand-yellow/20 dark:bg-brand-yellow/20 text-yellow-700 dark:text-brand-yellow' : 'text-gray-600 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700/50' }}" wire:navigate.hover>
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.tables') ? 'text-brand-orange' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                        Tables
                    </x-nav-link>
                    <x-nav-link :href="route('admin.reservations')" :active="request()->routeIs('admin.reservations')" class="flex w-full px-3 py-2 rounded-lg mb-1 {{ request()->routeIs('admin.reservations') ? 'bg-brand-yellow/20 dark:bg-brand-yellow/20 text-yellow-700 dark:text-brand-yellow' : 'text-gray-600 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700/50' }}" wire:navigate.hover>
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.reservations') ? 'text-brand-orange' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Reservations
                    </x-nav-link>
                @endif
            @endif

            <!-- Admin, Kitchen -->
            @if(in_array(auth()->user()->role, ['admin', 'kitchen']))
                <div class="pt-4 pb-2">
                    <p class="px-3 text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-wider">Kitchen</p>
                </div>
                <x-nav-link :href="route('kitchen.kds')" :active="request()->routeIs('kitchen.kds')" class="flex w-full px-3 py-2 rounded-lg mb-1 {{ request()->routeIs('kitchen.kds') ? 'bg-brand-yellow/20 dark:bg-brand-yellow/20 text-yellow-700 dark:text-brand-yellow' : 'text-gray-600 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700/50' }}" wire:navigate.hover>
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('kitchen.kds') ? 'text-brand-orange' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Kitchen (KDS)
                </x-nav-link>
            @endif

            <!-- Admin, Cashier -->
            @if(in_array(auth()->user()->role, ['admin', 'cashier']))
                <div class="pt-4 pb-2">
                    <p class="px-3 text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-wider">Payment</p>
                </div>
                <x-nav-link :href="route('cashier.pos')" :active="request()->routeIs('cashier.pos')" class="flex w-full px-3 py-2 rounded-lg mb-1 {{ request()->routeIs('cashier.pos') ? 'bg-brand-yellow/20 dark:bg-brand-yellow/20 text-yellow-700 dark:text-brand-yellow' : 'text-gray-600 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700/50' }}" wire:navigate.hover>
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('cashier.pos') ? 'text-brand-orange' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Cashier POS
                </x-nav-link>
                @if(auth()->user()->role === 'cashier')
                    <!-- Dedicated Cashier POS Terminal -->
                    <x-nav-link :href="route('cashier.terminal')" :active="request()->routeIs('cashier.terminal')" class="flex w-full px-3 py-2 rounded-lg mb-1 {{ request()->routeIs('cashier.terminal') ? 'bg-brand-yellow/20 dark:bg-brand-yellow/20 text-yellow-700 dark:text-brand-yellow' : 'text-gray-600 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700/50' }}" wire:navigate.hover>
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('cashier.terminal') ? 'text-brand-orange' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        POS Terminal
                    </x-nav-link>
                @endif
            @endif
        </div>

        <!-- Mobile Profile info & Settings -->
        <div class="md:hidden pt-4 pb-1 border-t border-gray-200 dark:border-slate-700">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-slate-200" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="font-medium text-sm text-gray-500 dark:text-slate-400">{{ auth()->user()->email }}</div>
            </div>
            
            <div class="px-4 mt-2 mb-2">
                @php
                    $role = auth()->user()->role;
                    $roleLabel = 'User';
                    $badgeColor = 'bg-gray-100 text-gray-800 dark:text-slate-200 border-gray-200 dark:border-slate-700';
                    
                    if ($role === 'admin') {
                        $roleLabel = 'Admin (Master)';
                        $badgeColor = 'bg-red-50 text-red-700 border-red-200';
                    } elseif ($role === 'cashier') {
                        $roleLabel = 'Kasir';
                        $badgeColor = 'bg-green-50 text-green-700 border-green-200';
                    } elseif ($role === 'kitchen') {
                        $roleLabel = 'Dapur';
                        $badgeColor = 'bg-orange-50 text-orange-700 border-orange-200';
                    } elseif ($role === 'customer' || $role === 'waiter') {
                        $roleLabel = 'Pelayan';
                        $badgeColor = 'bg-green-50 text-green-700 border-green-200';
                    }
                @endphp
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $badgeColor }}">
                    {{ $roleLabel }}
                </span>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile')" wire:navigate.hover>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>

        <!-- Desktop Settings & Logout (Bottom) -->
        <div class="hidden md:block p-4 border-t border-gray-100 dark:border-slate-700/50">
            <x-nav-link :href="route('profile')" :active="request()->routeIs('profile')" class="flex w-full px-3 py-2 rounded-lg mb-1 {{ request()->routeIs('profile') ? 'bg-brand-yellow/20 dark:bg-brand-yellow/20 text-yellow-700 dark:text-brand-yellow' : 'text-gray-600 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700/50' }}" wire:navigate.hover>
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('profile') ? 'text-brand-orange' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Profile
            </x-nav-link>
            
            <button wire:click="logout" class="flex w-full px-3 py-2 rounded-lg text-gray-600 hover:bg-red-50 hover:text-red-700 transition-colors text-sm font-medium leading-5">
                <svg class="w-5 h-5 mr-3 text-gray-400 dark:text-slate-500 group-hover:text-red-500 dark:group-hover:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Log Out
            </button>
        </div>
    </div>
</nav>
