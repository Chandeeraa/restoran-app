<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Table;
use App\Models\Reservation;
use App\Models\Order;

use Livewire\Attributes\Url;

#[Layout('layouts.customer')]
class Dashboard extends Component
{
    #[Url]
    public $tab = 'home';

    public $trackName = '';
    public $lastOrder = null;

    // Reservation Fields
    public $resName = '';
    public $resPhone = '';
    public $resDate = '';
    public $resTime = '';
    public $resGuests = 2;
    public $resNotes = '';

    public $showReservationSuccess = false;

    public function mount()
    {
        // Auto-load last order from session
        $orderNumber = session('last_order_number');
        if ($orderNumber) {
            $this->lastOrder = Order::with('items.menu')
                ->where('order_number', $orderNumber)
                ->first();
        }
    }

    public function clearLastOrder()
    {
        session()->forget('last_order_number');
        $this->lastOrder = null;
    }

    public function trackOrder()
    {
        $this->validate([
            'trackName' => 'required|string|min:2'
        ]);

        $order = Order::where('customer_name', 'like', '%' . $this->trackName . '%')
            ->latest()
            ->first();

        if ($order) {
            return redirect()->route('customer.track', ['order_number' => $order->order_number]);
        } else {
            $this->addError('trackName', 'Pesanan atas nama "' . $this->trackName . '" tidak ditemukan.');
        }
    }

    public function submitReservation()
    {
        $this->validate([
            'resName' => 'required|string|max:255',
            'resPhone' => 'required|string|max:20',
            'resDate' => 'required|date|after_or_equal:today',
            'resTime' => 'required',
            'resGuests' => 'required|integer|min:1|max:20',
        ]);

        Reservation::create([
            'customer_name' => $this->resName,
            'customer_phone' => $this->resPhone,
            'reservation_date' => $this->resDate,
            'reservation_time' => $this->resTime,
            'guest_count' => $this->resGuests,
            'notes' => $this->resNotes,
            'status' => 'pending'
        ]);

        $this->reset(['resName', 'resPhone', 'resDate', 'resTime', 'resGuests', 'resNotes']);
        $this->showReservationSuccess = true;
    }

    public function render()
    {
        $tables = Table::orderBy('table_number')->get();

        return view('livewire.customer.dashboard', [
            'tables' => $tables
        ]);
    }
}

