<?php

namespace App\Livewire\Kitchen;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Events\OrderStatusUpdated;

class KdsDashboard extends Component
{
    public $orders = [];

    public function mount()
    {
        $this->loadOrders();
    }

    public function loadOrders()
    {
        // Load pending and preparing orders, ordered by created_at ascending (oldest first)
        $this->orders = Order::with('items.menu')
            ->whereIn('status', ['pending', 'preparing'])
            ->orderBy('created_at', 'asc')
            ->get();
    }

    #[On('echo:kitchen-kds,OrderPlaced')]
    public function handleNewOrder($event)
    {
        // Reload orders when a new order is placed
        $this->loadOrders();
    }
    
    #[On('echo:kitchen-kds,OrderStatusUpdated')]
    public function handleOrderStatusUpdated($event)
    {
        // Reload orders when an order status is updated (e.g., from another Kitchen screen)
        $this->loadOrders();
    }

    public function updateStatus($orderId, $status)
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->status = $status;
            $order->save();
            
            // Broadcast the update so other KDS screens and the customer are updated
            event(new OrderStatusUpdated($order));
            
            $this->loadOrders();
        }
    }

    public function render()
    {
        return view('livewire.kitchen.kds-dashboard')->layout('layouts.app');
    }
}
