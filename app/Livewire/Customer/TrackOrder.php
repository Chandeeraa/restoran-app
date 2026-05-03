<?php

namespace App\Livewire\Customer;

use App\Models\Order;
use Livewire\Component;

class TrackOrder extends Component
{
    public $order_number;

    public function mount($order_number)
    {
        $this->order_number = $order_number;
        
        // Verify order exists, otherwise 404
        Order::where('order_number', $this->order_number)->firstOrFail();
    }

    public function getOrderProperty()
    {
        return Order::with('items.menu', 'table')
            ->where('order_number', $this->order_number)
            ->first();
    }

    public function cancelOrder()
    {
        $order = $this->order;

        // Only allow cancellation if still pending
        if (!$order || $order->status !== 'pending') {
            return;
        }

        $order->status = 'cancelled';
        $order->save();

        // Free up the table if dine-in
        if ($order->order_type === 'dine-in' && $order->table_id) {
            \App\Models\Table::where('id', $order->table_id)->update(['status' => 'available']);
        }
    }

    public function render()
    {
        return view('livewire.customer.track-order', [
            'order' => $this->order
        ])->layout('layouts.customer');
    }
}
