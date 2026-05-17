<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-emerald-600 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    @php
        $todayOrders = \App\Models\Order::whereDate('created_at', today())->count();
        $todayRevenue = \App\Models\Order::whereDate('created_at', today())->where('payment_status', 'paid')->sum('total_price');
        $totalMenus = \App\Models\Menu::count();
        $activeTables = \App\Models\Table::where('status', 'occupied')->count();
    @endphp

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-br from-brand-yellow to-brand-orange dark:from-green-500 dark:to-emerald-600 rounded-3xl shadow-lg overflow-hidden relative">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white dark:bg-slate-800 opacity-20 dark:opacity-10 rounded-full blur-2xl"></div>
                <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-24 h-24 bg-white dark:bg-slate-800 opacity-20 dark:opacity-10 rounded-full blur-xl"></div>
                
                <div class="p-8 sm:p-10 relative z-10 text-white dark:text-white">
                    <h3 class="text-3xl font-extrabold mb-2 text-slate-800 dark:text-white">Welcome back, {{ auth()->user()->name }}! 👋</h3>
                    <p class="text-slate-700 dark:text-green-100 font-medium text-lg max-w-2xl">Here's what's happening in your restaurant today. Manage your menus, monitor the kitchen, or process payments directly from your control panel.</p>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Stat 1 -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6 flex items-center space-x-4 transition-transform hover:-translate-y-1 hover:border-brand-yellow duration-300">
                    <div class="p-3 rounded-full bg-brand-yellow/20 text-brand-orange">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-slate-400">Today's Orders</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-slate-100">{{ $todayOrders }}</p>
                    </div>
                </div>
                
                <!-- Stat 2 -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6 flex items-center space-x-4 transition-transform hover:-translate-y-1 hover:border-brand-yellow duration-300">
                    <div class="p-3 rounded-full bg-brand-yellow/20 text-brand-orange">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-slate-400">Today's Revenue</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-slate-100">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Stat 3 -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6 flex items-center space-x-4 transition-transform hover:-translate-y-1 hover:border-brand-yellow duration-300">
                    <div class="p-3 rounded-full bg-brand-yellow/20 text-brand-orange">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-slate-400">Total Menus</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-slate-100">{{ $totalMenus }}</p>
                    </div>
                </div>

                <!-- Stat 4 -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6 flex items-center space-x-4 transition-transform hover:-translate-y-1 hover:border-brand-yellow duration-300">
                    <div class="p-3 rounded-full bg-brand-yellow/20 text-brand-orange">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-slate-400">Active Tables</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-slate-100">{{ $activeTables }}</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <h3 class="text-xl font-bold text-gray-800 dark:text-slate-200 mt-8 mb-4 px-2">Quick Access</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6                <a href="{{ route('cashier.terminal') }}" class="group block bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6 hover:shadow-md hover:border-brand-yellow transition-all">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-brand-yellow/20 rounded-xl flex items-center justify-center text-brand-orange group-hover:bg-brand-orange group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-brand-orange transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                    <h4 class="text-lg font-bold text-gray-900 dark:text-slate-100 mb-1">POS Terminal <span class="text-xs bg-brand-yellow/30 text-brand-orange px-2 py-0.5 rounded-full ml-1">New</span></h4>
                    <p class="text-sm text-gray-500 dark:text-slate-400">Take orders with the new POS design.</p>
                </a>

                <a href="{{ route('cashier.pos') }}" class="group block bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6 hover:shadow-md hover:border-brand-yellow transition-all">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-brand-yellow/20 rounded-xl flex items-center justify-center text-brand-orange group-hover:bg-brand-orange group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-brand-orange transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                    <h4 class="text-lg font-bold text-gray-900 dark:text-slate-100 mb-1">Cashier Payments</h4>
                    <p class="text-sm text-gray-500 dark:text-slate-400">Process payments and print receipts.</p>
                </a>

                <a href="{{ route('kitchen.kds') }}" class="group block bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6 hover:shadow-md hover:border-brand-yellow transition-all">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-brand-yellow/20 rounded-xl flex items-center justify-center text-brand-orange group-hover:bg-brand-orange group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-brand-orange transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                    <h4 class="text-lg font-bold text-gray-900 dark:text-slate-100 mb-1">Kitchen Display</h4>
                    <p class="text-sm text-gray-500 dark:text-slate-400">Monitor and update incoming orders.</p>
                </a>

                <a href="{{ route('admin.menus') }}" class="group block bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6 hover:shadow-md hover:border-brand-yellow transition-all">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-brand-yellow/20 rounded-xl flex items-center justify-center text-brand-orange group-hover:bg-brand-orange group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-brand-orange transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                    <h4 class="text-lg font-bold text-gray-900 dark:text-slate-100 mb-1">Menu Manager</h4>
                    <p class="text-sm text-gray-500 dark:text-slate-400">Add, edit, or remove catalog items.</p>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
