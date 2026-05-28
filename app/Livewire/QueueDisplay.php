<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;

class QueueDisplay extends Component
{
    public function getPreparingOrdersProperty()
    {
        return Order::whereDate('created_at', today())
            ->whereIn('status', ['pending', 'cooking'])
            ->where('payment_status', 'paid')
            ->orderBy('queue_number', 'asc')
            ->get();
    }

    public function getReadyOrdersProperty()
    {
        return Order::whereDate('created_at', today())
            ->where('status', 'ready')
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.queue-display', [
            'preparingOrders' => $this->preparingOrders,
            'readyOrders' => $this->readyOrders,
        ])->layout('layouts.blank'); // Standalone blank layout
    }
}
