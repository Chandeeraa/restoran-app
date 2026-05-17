<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Table;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class StatsDashboard extends Component
{
    public function getTodayRevenueProperty()
    {
        return Order::whereDate('created_at', today())
            ->where('payment_status', 'paid')
            ->sum('total_price');
    }

    public function getTodayOrdersCountProperty()
    {
        return Order::whereDate('created_at', today())->count();
    }

    public function getTodayPaidCountProperty()
    {
        return Order::whereDate('created_at', today())
            ->where('payment_status', 'paid')->count();
    }

    public function getTodayUnpaidCountProperty()
    {
        return Order::whereDate('created_at', today())
            ->where('payment_status', 'unpaid')
            ->whereNotIn('status', ['cancelled'])
            ->count();
    }

    public function getTodayCancelledCountProperty()
    {
        return Order::whereDate('created_at', today())
            ->where('status', 'cancelled')->count();
    }

    public function getTopMenusProperty()
    {
        return OrderItem::select('menu_id', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(quantity * price) as total_revenue'))
            ->with('menu')
            ->whereHas('order', fn ($q) => $q->whereDate('created_at', today()))
            ->groupBy('menu_id')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();
    }

    public function getPaymentMethodStatsProperty()
    {
        return Order::select('payment_method_type', DB::raw('count(*) as count'), DB::raw('SUM(total_price) as total'))
            ->selectRaw('(SELECT payment_method FROM payments WHERE payments.order_id = orders.id LIMIT 1) as payment_method_type')
            ->whereDate('orders.created_at', today())
            ->where('payment_status', 'paid')
            ->groupBy('payment_method_type')
            ->get();
    }

    public function getTableStatsProperty()
    {
        return [
            'total' => Table::count(),
            'occupied' => Table::where('status', 'occupied')->count(),
            'available' => Table::where('status', 'available')->count(),
        ];
    }

    public function getRecentOrdersProperty()
    {
        return Order::with('table')
            ->whereDate('created_at', today())
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.stats-dashboard', [
            'todayRevenue' => $this->todayRevenue,
            'todayOrdersCount' => $this->todayOrdersCount,
            'todayPaidCount' => $this->todayPaidCount,
            'todayUnpaidCount' => $this->todayUnpaidCount,
            'todayCancelledCount' => $this->todayCancelledCount,
            'topMenus' => $this->topMenus,
            'tableStats' => $this->tableStats,
            'recentOrders' => $this->recentOrders,
        ])->layout('layouts.app');
    }
}
