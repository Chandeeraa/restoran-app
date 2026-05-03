<?php

namespace App\Livewire\Cashier;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Table;
use Livewire\Component;
use Livewire\Attributes\On;

class PosDashboard extends Component
{
    public $orders = [];
    public $selectedOrder = null;
    
    // Payment Modal State
    public $showPaymentModal = false;
    public $paymentMethod = 'cash';
    public $amountGiven = '';
    public $change = 0;
    public $paymentError = '';

    public function mount()
    {
        $this->loadOrders();
    }

    public function loadOrders()
    {
        // Load all active orders (not completed) or today's completed orders
        $this->orders = Order::with('items.menu', 'table')
            ->whereDate('created_at', today())
            ->orWhere('status', '!=', 'completed')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    #[On('echo:kitchen-kds,OrderPlaced')]
    public function handleNewOrder($event)
    {
        $this->loadOrders();
    }
    
    #[On('echo:kitchen-kds,OrderStatusUpdated')]
    public function handleOrderStatusUpdated($event)
    {
        $this->loadOrders();
    }

    public function openPaymentModal($orderId)
    {
        $this->selectedOrder = Order::with('items.menu')->find($orderId);
        $this->paymentMethod = 'cash';
        $this->amountGiven = '';
        $this->change = 0;
        $this->paymentError = '';
        $this->showPaymentModal = true;
    }

    public function closePaymentModal()
    {
        $this->showPaymentModal = false;
        $this->selectedOrder = null;
    }

    public function updatedAmountGiven($value)
    {
        $amount = floatval($value);
        if ($this->selectedOrder) {
            $total = floatval($this->selectedOrder->total_price);
            if ($amount >= $total) {
                $this->change = $amount - $total;
                $this->paymentError = '';
            } else {
                $this->change = 0;
                if ($amount > 0) {
                    $this->paymentError = 'Jumlah uang kurang dari total tagihan.';
                }
            }
        }
    }

    public function processPayment()
    {
        if (!$this->selectedOrder) return;
        
        $amount = floatval($this->amountGiven);
        $total = floatval($this->selectedOrder->total_price);

        if ($this->paymentMethod === 'cash' && $amount < $total) {
            $this->paymentError = 'Uang tidak cukup.';
            return;
        }

        // For non-cash, assume exact amount
        if ($this->paymentMethod !== 'cash') {
            $amount = $total;
        }

        // Create Payment record
        Payment::create([
            'order_id' => $this->selectedOrder->id,
            'payment_method' => $this->paymentMethod,
            'amount' => $amount,
            'status' => 'success',
        ]);

        // Update Order
        $this->selectedOrder->payment_status = 'paid';
        $this->selectedOrder->status = 'completed';
        $this->selectedOrder->save();

        // Update Table status if dine-in
        if ($this->selectedOrder->order_type === 'dine-in' && $this->selectedOrder->table_id) {
            Table::where('id', $this->selectedOrder->table_id)->update(['status' => 'available']);
        }
        
        // Broadcast that the order is updated
        event(new \App\Events\OrderStatusUpdated($this->selectedOrder));

        $this->closePaymentModal();
        $this->loadOrders();
        
        session()->flash('success', 'Pembayaran berhasil diproses!');
    }

    public function render()
    {
        return view('livewire.cashier.pos-dashboard')->layout('layouts.app');
    }
}
