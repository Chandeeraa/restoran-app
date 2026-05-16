<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('/order', \App\Livewire\Customer\OrderPage::class)->name('order');
Route::get('/track/{order_number}', \App\Livewire\Customer\TrackOrder::class)->name('customer.track');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::view('profile', 'profile')->name('profile');
    
    // Admin Routes
    Route::get('/admin/users', \App\Livewire\Admin\UserManager::class)->name('admin.users');
    Route::get('/admin/categories', \App\Livewire\Admin\CategoryManager::class)->name('admin.categories');
    Route::get('/admin/menus', \App\Livewire\Admin\MenuManager::class)->name('admin.menus');
    Route::get('/admin/tables', \App\Livewire\Admin\TableManager::class)->name('admin.tables');
    Route::get('/admin/settings', \App\Livewire\Admin\SettingManager::class)->name('admin.settings');
    Route::get('/admin/discounts', \App\Livewire\Admin\DiscountManager::class)->name('admin.discounts');
    Route::get('/admin/stats', \App\Livewire\Admin\StatsDashboard::class)->name('admin.stats');
    Route::get('/admin/report/print', function () {
        abort_if(auth()->user()->role !== 'admin', 403);
        $period = request('period', 'today');
        $query = \App\Models\Order::with('items.menu', 'payment')->where('payment_status', 'paid');
        if ($period === 'today') {
            $query->whereDate('created_at', today());
            $label = 'Hari Ini (' . now()->format('d/m/Y') . ')';
        } elseif ($period === 'month') {
            $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
            $label = 'Bulan Ini (' . now()->format('F Y') . ')';
        } else {
            $label = 'Semua Waktu';
        }
        $orders = $query->orderBy('created_at', 'desc')->get();
        $totalRevenue = $orders->sum('total_price');
        $setting = \App\Models\StoreSetting::first();
        return view('admin.print-report', compact('orders', 'totalRevenue', 'label', 'setting', 'period'));
    })->name('admin.report.print');
    
    // Kitchen Routes
    Route::get('/kitchen/kds', \App\Livewire\Kitchen\KdsDashboard::class)->name('kitchen.kds');
    
    // Cashier Routes
    Route::get('/cashier/pos', \App\Livewire\Cashier\PosDashboard::class)->name('cashier.pos');
    Route::get('/cashier/receipt/{order}', function (\App\Models\Order $order) {
        $setting = \App\Models\StoreSetting::first();
        return view('cashier.receipt', compact('order', 'setting'));
    })->name('cashier.receipt');
});

require __DIR__.'/auth.php';
