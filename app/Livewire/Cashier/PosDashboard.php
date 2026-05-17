<?php

namespace App\Livewire\Cashier;

use App\Events\OrderStatusUpdated;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Table;
use Livewire\Attributes\On;
use Livewire\Component;

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

    public $paymentFilter = 'all';

    public $search = '';

    public function mount()
    {
        $this->loadOrders();
    }

    public function updatedSearch()
    {
        $this->loadOrders();
    }

    public function setFilter($filter)
    {
        $this->paymentFilter = $filter;
        $this->loadOrders();
    }

    public function loadOrders()
    {
        // Load all active orders (not completed) or today's completed orders
        $query = Order::with('items.menu', 'table')
            ->where(function ($q) {
                if (empty($this->search)) {
                    $q->whereDate('created_at', today())
                        ->orWhere('status', '!=', 'completed');
                }
            });

        if (! empty($this->search)) {
            $query->where(function ($q) {
                $q->where('order_number', 'like', '%'.$this->search.'%')
                    ->orWhere('customer_name', 'like', '%'.$this->search.'%');
            });
        }

        if ($this->paymentFilter === 'unpaid') {
            $query->where('payment_status', 'unpaid');
        } elseif ($this->paymentFilter === 'paid') {
            $query->where('payment_status', 'paid');
        }

        $this->orders = $query->orderBy('created_at', 'desc')->get();
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
        if (! $this->selectedOrder) {
            return;
        }

        // Re-fetch to ensure fresh status
        $order = Order::find($this->selectedOrder->id);
        if ($order->status === 'cancelled') {
            $this->paymentError = 'Pesanan ini sudah dibatalkan dan tidak bisa diproses pembayarannya.';

            return;
        }

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
            'amount' => $total,
            'status' => 'success',
        ]);

        // Assign queue number if not already assigned
        if (! $order->queue_number) {
            $queueType = $this->paymentMethod === 'cash' ? 1 : 2;
            $queueNumber = $this->getNextQueueNumber($queueType);
            $order->queue_type = $queueType;
            $order->queue_number = $queueNumber;
        }
        $order->payment_method = $this->paymentMethod;

        // Update payment status
        $order->payment_status = 'paid';

        // Auto-complete if the order is already cooked/ready and payment is processed.
        if (in_array($order->status, ['ready', 'served'])) {
            $order->status = 'completed';

            // Release table if dine-in
            if ($order->order_type === 'dine-in' && $order->table_id) {
                Table::where('id', $order->table_id)->update(['status' => 'available']);
            }
        }

        $order->save();

        // Broadcast that the order is updated
        event(new OrderStatusUpdated($order));

        $this->closePaymentModal();
        $this->loadOrders();

        session()->flash('success', 'Pembayaran berhasil diproses!');
    }

    public function cancelOrder($orderId)
    {
        $order = Order::find($orderId);

        if ($order && $order->payment_status !== 'paid' && $order->status !== 'cancelled') {
            $order->status = 'cancelled';
            $order->save();

            // Release table if dine-in
            if ($order->order_type === 'dine-in' && $order->table_id) {
                Table::where('id', $order->table_id)->update(['status' => 'available']);
            }

            // Broadcast the update
            event(new OrderStatusUpdated($order));

            $this->loadOrders();
            session()->flash('success', 'Pesanan '.$order->order_number.' berhasil dibatalkan.');
        }
    }

    public function completeOrder($orderId)
    {
        $order = Order::find($orderId);
        if ($order && $order->status !== 'completed' && $order->status !== 'cancelled') {
            $order->status = 'completed';
            $order->save();

            // Release table if dine-in
            if ($order->order_type === 'dine-in' && $order->table_id) {
                Table::where('id', $order->table_id)->update(['status' => 'available']);
            }

            event(new OrderStatusUpdated($order));

            $this->loadOrders();
            session()->flash('success', 'Pesanan '.$order->order_number.' diselesaikan.');
        }
    }

    public function deleteOrder($orderId)
    {
        if (auth()->user()->role !== 'admin') {
            return;
        }

        $order = Order::find($orderId);
        if ($order) {
            // Release table if order is still active
            if ($order->order_type === 'dine-in' && $order->table_id && in_array($order->status, ['pending', 'cooking', 'ready', 'served'])) {
                Table::where('id', $order->table_id)->update(['status' => 'available']);
            }

            // Delete relationships to avoid orphan records
            $order->items()->delete();
            if ($order->payment) {
                $order->payment()->delete();
            }

            $order->delete();

            $this->loadOrders();
            session()->flash('success', 'Riwayat pesanan berhasil dihapus secara permanen.');
        }
    }

    public function render()
    {
        return view('livewire.cashier.pos-dashboard')->layout('layouts.app');
    }

    /**
     * Assign queue number based on payment method.
     * Type 1 = Cash (priority), Type 2 = QRIS / non-cash.
     */
    private function getNextQueueNumber(int $queueType): int
    {
        $last = Order::whereDate('created_at', today())
            ->where('queue_type', $queueType)
            ->max('queue_number');

        return ($last ?? 0) + 1;
    }
}
