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
    Route::get('/admin/categories', \App\Livewire\Admin\CategoryManager::class)->name('admin.categories');
    Route::get('/admin/menus', \App\Livewire\Admin\MenuManager::class)->name('admin.menus');
    Route::get('/admin/tables', \App\Livewire\Admin\TableManager::class)->name('admin.tables');
    Route::get('/admin/stats', \App\Livewire\Admin\StatsDashboard::class)->name('admin.stats');
    
    // Kitchen Routes
    Route::get('/kitchen/kds', \App\Livewire\Kitchen\KdsDashboard::class)->name('kitchen.kds');
    
    // Cashier Routes
    Route::get('/cashier/pos', \App\Livewire\Cashier\PosDashboard::class)->name('cashier.pos');
    Route::get('/cashier/receipt/{order}', function (\App\Models\Order $order) {
        return view('cashier.receipt', compact('order'));
    })->name('cashier.receipt');
});

require __DIR__.'/auth.php';
