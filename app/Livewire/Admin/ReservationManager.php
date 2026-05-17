<?php

namespace App\Livewire\Admin;

use App\Models\Reservation;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class ReservationManager extends Component
{
    use WithPagination;

    public $search = '';

    public $statusFilter = '';

    public function mount()
    {
        abort_if(auth()->user()->role !== 'admin', 403);
    }

    public function updateStatus($id, $status)
    {
        $reservation = Reservation::find($id);
        if ($reservation) {
            $reservation->update(['status' => $status]);
        }
    }

    public function render()
    {
        $query = Reservation::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('customer_name', 'like', '%'.$this->search.'%')
                    ->orWhere('customer_phone', 'like', '%'.$this->search.'%');
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        return view('livewire.admin.reservation-manager', [
            'reservations' => $query->orderBy('reservation_date', 'asc')->orderBy('reservation_time', 'asc')->paginate(10),
        ])->title('Reservations');
    }
}
