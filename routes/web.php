<?php

use App\Http\Controllers\ReceiptController;
use App\Livewire\Admin\CategoryManager;
use App\Livewire\Admin\DiscountManager;
use App\Livewire\Admin\MenuManager;
use App\Livewire\Admin\ReservationManager;
use App\Livewire\Admin\SettingManager;
use App\Livewire\Admin\StatsDashboard;
use App\Livewire\Admin\TableManager;
use App\Livewire\Admin\UserManager;
use App\Livewire\Cashier\PosDashboard;
use App\Livewire\Cashier\PosTerminal;
use App\Livewire\Customer\Dashboard;
use App\Livewire\Customer\OrderPage;
use App\Livewire\Customer\TrackOrder;
use App\Livewire\Kitchen\KdsDashboard;
use App\Models\Order;
use App\Models\StoreSetting;
use Illuminate\Support\Facades\Route;

Route::get('/', Dashboard::class)->name('home');

Route::get('/order', OrderPage::class)->name('order');
Route::get('/track/{order_number}', TrackOrder::class)->name('customer.track');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::view('profile', 'profile')->name('profile');
    Route::post('/profile/photo', [\App\Http\Controllers\ProfilePhotoController::class, 'update'])->name('profile.photo.update');
    Route::delete('/profile/photo', [\App\Http\Controllers\ProfilePhotoController::class, 'destroy'])->name('profile.photo.destroy');

    // Admin Only Routes
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/users', UserManager::class)->name('admin.users');
        Route::get('/admin/categories', CategoryManager::class)->name('admin.categories');
        Route::get('/admin/menus', MenuManager::class)->name('admin.menus');
        Route::get('/admin/settings', SettingManager::class)->name('admin.settings');
        Route::get('/admin/discounts', DiscountManager::class)->name('admin.discounts');
        Route::get('/admin/stats', StatsDashboard::class)->name('admin.stats');
        Route::get('/admin/report/print', function () {
            $period = request('period', 'today');
            $query = Order::with('items.menu', 'payment')->where('payment_status', 'paid');
            if ($period === 'today') {
                $query->whereDate('created_at', today());
                $label = 'Hari Ini ('.now()->format('d/m/Y').')';
            } elseif ($period === 'month') {
                $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
                $label = 'Bulan Ini ('.now()->format('F Y').')';
            } else {
                $label = 'Semua Waktu';
            }
            $orders = $query->orderBy('created_at', 'desc')->get();
            $totalRevenue = $orders->sum('total_price');
            $setting = StoreSetting::first();

            return view('admin.print-report', compact('orders', 'totalRevenue', 'label', 'setting', 'period'));
        })->name('admin.report.print');
    });

    // Admin & Cashier Routes (Tables & Reservations)
    Route::middleware(['role:admin,cashier'])->group(function () {
        Route::get('/admin/tables', TableManager::class)->name('admin.tables');
        Route::get('/admin/reservations', ReservationManager::class)->name('admin.reservations');
    });

    // Kitchen Routes
    Route::middleware(['role:admin,kitchen'])->group(function () {
        Route::get('/kitchen/kds', KdsDashboard::class)->name('kitchen.kds');
    });

    // Cashier Routes
    Route::middleware(['role:admin,cashier'])->group(function () {
        Route::get('/cashier/pos', PosDashboard::class)->name('cashier.pos');
        Route::get('/cashier/terminal', PosTerminal::class)->name('cashier.terminal');
        Route::get('/cashier/receipt/{order}', [ReceiptController::class, 'show'])->name('cashier.receipt');
        Route::get('/cashier/receipt/{order}/print', [ReceiptController::class, 'print'])->name('cashier.receipt.print');
    });
});

require __DIR__.'/auth.php';
