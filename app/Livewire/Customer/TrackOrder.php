<?php

namespace App\Livewire\Customer;

use App\Models\Order;
use App\Models\Table;
use Livewire\Component;

class TrackOrder extends Component
{
    public $order_number;

    public $previousStatus = null;

    public function mount($order_number)
    {
        $this->order_number = $order_number;
        $order = Order::where('order_number', $this->order_number)->firstOrFail();
        $this->previousStatus = $order->status;
    }

    /**
     * Apakah order berisi minimal 1 item makanan (bukan minuman)?
     */
    private function orderHasFood(Order $order): bool
    {
        foreach ($order->items as $item) {
            $cat = $item->menu?->category;
            if ($cat && ! $cat->is_drink) {
                return true;
            }
        }

        return false;
    }

    public function cancelOrder()
    {
        $order = Order::with('items')->where('order_number', $this->order_number)->first();

        if (! $order || $order->status !== 'pending') {
            return;
        }

        $order->status = 'cancelled';
        $order->save();

        if ($order->order_type === 'dine-in' && $order->table_id) {
            Table::where('id', $order->table_id)->update(['status' => 'available']);
        }
    }

    public function completeOrder()
    {
        $order = Order::where('order_number', $this->order_number)->first();
        if ($order && $order->status === 'ready' && $order->payment_status === 'paid') {
            $order->status = 'completed';
            $order->save();

            if ($order->order_type === 'dine-in' && $order->table_id) {
                Table::where('id', $order->table_id)->update(['status' => 'available']);
            }
        }
    }

    public function render()
    {
        $order = Order::with(['items.menu.category', 'table'])
            ->where('order_number', $this->order_number)
            ->first();

        $hasFood = $order ? $this->orderHasFood($order) : false;
        $shouldPlayAudio = $order && $order->status === 'ready' && $hasFood;

        return view('livewire.customer.track-order', [
            'order' => $order,
            'hasFood' => $hasFood,
            'shouldPlayAudio' => $shouldPlayAudio,
        ])->layout('layouts.customer');
    }
}
