<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Table;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class StatsDashboard extends Component
{
    public $period = 'today';

    public function setPeriod($period)
    {
        if (in_array($period, ['today', 'week', 'month'])) {
            $this->period = $period;
        }
    }

    private function applyPeriodFilter($query)
    {
        if ($this->period === 'week') {
            return $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($this->period === 'month') {
            return $query->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]);
        }
        
        return $query->whereDate('created_at', today());
    }

    public function getTodayRevenueProperty()
    {
        $query = Order::where('payment_status', 'paid');
        $query = $this->applyPeriodFilter($query);
        return $query->sum('total_price');
    }

    public function getTodayOrdersCountProperty()
    {
        $query = Order::query();
        $query = $this->applyPeriodFilter($query);
        return $query->count();
    }

    public function getTodayPaidCountProperty()
    {
        $query = Order::where('payment_status', 'paid');
        $query = $this->applyPeriodFilter($query);
        return $query->count();
    }

    public function getTodayUnpaidCountProperty()
    {
        $query = Order::where('payment_status', 'unpaid')
            ->whereNotIn('status', ['cancelled']);
        $query = $this->applyPeriodFilter($query);
        return $query->count();
    }

    public function getTodayCancelledCountProperty()
    {
        $query = Order::where('status', 'cancelled');
        $query = $this->applyPeriodFilter($query);
        return $query->count();
    }

    public function getTopMenusProperty()
    {
        return OrderItem::select('menu_id', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(quantity * price) as total_revenue'))
            ->with('menu')
            ->whereHas('order', fn ($q) => $this->applyPeriodFilter($q))
            ->groupBy('menu_id')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();
    }

    public function getRevenueByCategoryProperty()
    {
        return OrderItem::select('categories.name as category_name', DB::raw('SUM(order_items.quantity * order_items.price) as total_revenue'))
            ->join('menus', 'order_items.menu_id', '=', 'menus.id')
            ->join('categories', 'menus.category_id', '=', 'categories.id')
            ->whereHas('order', function ($q) {
                $q = $this->applyPeriodFilter($q);
                $q->where('payment_status', 'paid');
            })
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total_revenue')
            ->get();
    }

    public function getPaymentMethodStatsProperty()
    {
        $query = Order::select('payment_method_type', DB::raw('count(*) as count'), DB::raw('SUM(total_price) as total'))
            ->selectRaw('(SELECT payment_method FROM payments WHERE payments.order_id = orders.id LIMIT 1) as payment_method_type')
            ->where('payment_status', 'paid');
        $query = $this->applyPeriodFilter($query);
        return $query->groupBy('payment_method_type')->get();
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
        $query = Order::with('table');
        $query = $this->applyPeriodFilter($query);
        return $query->orderByDesc('created_at')->limit(8)->get();
    }

    public function exportToCsv()
    {
        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=laporan-pendapatan-" . $this->period . "-" . now()->format('YmdHis') . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $orders = Order::with('table')
            ->where('payment_status', 'paid');
        $orders = $this->applyPeriodFilter($orders);
        $ordersList = $orders->orderBy('created_at', 'desc')->get();

        $callback = function() use($ordersList) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF");
            fputcsv($file, ['No. Pesanan', 'Pelanggan', 'Tipe', 'Meja', 'Subtotal', 'Pajak', 'Biaya Layanan', 'Diskon', 'Total', 'Tanggal']);

            foreach ($ordersList as $order) {
                fputcsv($file, [
                    $order->order_number,
                    $order->customer_name ?? 'Guest',
                    $order->order_type,
                    $order->table ? $order->table->table_number : '-',
                    $order->subtotal_price,
                    $order->tax_amount,
                    $order->service_charge_amount,
                    $order->discount_amount,
                    $order->total_price,
                    $order->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function getLowStockMenusProperty()
    {
        return \App\Models\Menu::where('track_stock', true)
            ->orderBy('stock', 'asc')
            ->limit(5)
            ->get();
    }

    public function restockMenu($menuId)
    {
        $menu = \App\Models\Menu::find($menuId);
        if ($menu) {
            $menu->stock += 50;
            $menu->is_available = true;
            $menu->save();
            
            $this->dispatch('show-toast', message: "Restok {$menu->name} (+50 Porsi) Berhasil!");
        }
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
            'revenueByCategory' => $this->revenueByCategory,
            'tableStats' => $this->tableStats,
            'recentOrders' => $this->recentOrders,
            'lowStockMenus' => $this->lowStockMenus,
        ])->layout('layouts.app');
    }
}
