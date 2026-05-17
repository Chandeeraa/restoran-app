<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\Customer\Dashboard::class)->name('home');

Route::get('/order', \App\Livewire\Customer\OrderPage::class)->name('order');
Route::get('/track/{order_number}', \App\Livewire\Customer\TrackOrder::class)->name('customer.track');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::view('profile', 'profile')->name('profile');
    
    // Admin Only Routes
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/users', \App\Livewire\Admin\UserManager::class)->name('admin.users');
        Route::get('/admin/categories', \App\Livewire\Admin\CategoryManager::class)->name('admin.categories');
        Route::get('/admin/menus', \App\Livewire\Admin\MenuManager::class)->name('admin.menus');
        Route::get('/admin/settings', \App\Livewire\Admin\SettingManager::class)->name('admin.settings');
        Route::get('/admin/discounts', \App\Livewire\Admin\DiscountManager::class)->name('admin.discounts');
        Route::get('/admin/stats', \App\Livewire\Admin\StatsDashboard::class)->name('admin.stats');
        Route::get('/admin/report/print', function () {
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
    });

    // Admin & Cashier Routes (Tables & Reservations)
    Route::middleware(['role:admin,cashier'])->group(function () {
        Route::get('/admin/tables', \App\Livewire\Admin\TableManager::class)->name('admin.tables');
        Route::get('/admin/reservations', \App\Livewire\Admin\ReservationManager::class)->name('admin.reservations');
    });
    
    // Kitchen Routes
    Route::middleware(['role:admin,kitchen'])->group(function () {
        Route::get('/kitchen/kds', \App\Livewire\Kitchen\KdsDashboard::class)->name('kitchen.kds');
    });
    
    // Cashier Routes
    Route::middleware(['role:admin,cashier'])->group(function () {
        Route::get('/cashier/pos', \App\Livewire\Cashier\PosDashboard::class)->name('cashier.pos');
        Route::get('/cashier/terminal', \App\Livewire\Cashier\PosTerminal::class)->name('cashier.terminal');
        Route::get('/cashier/receipt/{order}', [\App\Http\Controllers\ReceiptController::class, 'show'])->name('cashier.receipt');
        Route::get('/cashier/receipt/{order}/print', [\App\Http\Controllers\ReceiptController::class, 'print'])->name('cashier.receipt.print');
    });
});

require __DIR__.'/auth.php';
