<?php

namespace App\Livewire\Cashier;

use App\Events\OrderPlaced;
use App\Livewire\Actions\Logout;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\StoreSetting;
use App\Models\Table;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.pos-theme')]
class PosTerminal extends Component
{
    public $search = '';

    public $activeCategoryId = null;

    public $activeTab = 'menu'; // 'menu', 'tables'

    public $cart = [];

    public $selectedTableId = null;

    public $customerName = '';

    public $orderType = 'dine-in';

    // Checkout Modal
    public $showCheckout = false;

    public $paymentMethod = 'cash';

    public $amountGiven = null;

    public $paymentError = null;

    // Success Modal
    public $showSuccess = false;

    public $completedOrder = null;

    public function mount()
    {
        abort_if(auth()->user()->role !== 'cashier' && auth()->user()->role !== 'admin', 403);
    }

    public function logout(Logout $logout)
    {
        $logout();

        return $this->redirect('/', navigate: true);
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function setCategory($id)
    {
        $this->activeCategoryId = $id;
    }

    public function addToCart($menuId)
    {
        $menu = Menu::find($menuId);
        if (! $menu) {
            return;
        }

        $found = false;
        foreach ($this->cart as $key => $item) {
            if ($item['id'] == $menuId) {
                $this->cart[$key]['quantity']++;
                $found = true;
                break;
            }
        }

        if (! $found) {
            $this->cart[] = [
                'id' => $menu->id,
                'name' => $menu->name,
                'price' => $menu->price,
                'quantity' => 1,
                'image' => $menu->image ? asset('storage/'.$menu->image) : null,
            ];
        }
    }

    public function updateQuantity($menuId, $change)
    {
        foreach ($this->cart as $key => $item) {
            if ($item['id'] == $menuId) {
                $this->cart[$key]['quantity'] += $change;
                if ($this->cart[$key]['quantity'] <= 0) {
                    unset($this->cart[$key]);
                }
                break;
            }
        }
        $this->cart = array_values($this->cart); // Re-index
    }

    public function removeCartItem($menuId)
    {
        foreach ($this->cart as $key => $item) {
            if ($item['id'] == $menuId) {
                unset($this->cart[$key]);
                break;
            }
        }
        $this->cart = array_values($this->cart);
    }

    public function setTable($tableId)
    {
        if ($this->selectedTableId === $tableId) {
            $this->selectedTableId = null; // Toggle off
        } else {
            $this->selectedTableId = $tableId;
        }
    }

    public function getSubtotalProperty()
    {
        $total = 0;
        foreach ($this->cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return $total;
    }

    public function getTaxAmountProperty()
    {
        $settings = StoreSetting::first();
        $rate = $settings ? $settings->tax_rate : 0;

        return $this->subtotal * ($rate / 100);
    }

    public function getTotalProperty()
    {
        return $this->subtotal + $this->taxAmount;
    }

    public function openCheckout()
    {
        if (empty($this->cart)) {
            // Can't checkout empty cart
            return;
        }

        if ($this->orderType === 'dine-in' && ! $this->selectedTableId) {
            $this->addError('table', 'Please select a table first for Dine-In!');

            return;
        }

        $this->showCheckout = true;
        $this->amountGiven = null;
        $this->paymentError = null;
    }

    public function closeCheckout()
    {
        $this->showCheckout = false;
    }

    public function processOrder()
    {
        if ($this->paymentMethod === 'cash') {
            if (empty($this->amountGiven) || $this->amountGiven < $this->total) {
                $this->paymentError = 'Amount given is less than total price.';

                return;
            }
        }

        $table = Table::find($this->selectedTableId);

        $queueType = $this->paymentMethod === 'cash' ? 1 : 2;
        $queueNumber = $this->getNextQueueNumber($queueType);

        $order = Order::create([
            'order_number' => 'ORD-'.strtoupper(Str::random(8)),
            'table_id' => $this->orderType === 'dine-in' ? $this->selectedTableId : null,
            'customer_name' => $this->customerName ?: 'Guest',
            'order_type' => $this->orderType,
            'status' => 'pending',
            'payment_status' => 'paid',
            'payment_method' => $this->paymentMethod,
            'queue_type' => $queueType,
            'queue_number' => $queueNumber,
            'subtotal_price' => $this->subtotal,
            'tax_amount' => $this->taxAmount,
            'service_charge_amount' => 0,
            'discount_amount' => 0,
            'total_price' => $this->total,
        ]);

        foreach ($this->cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'notes' => null,
            ]);
        }

        if ($this->orderType === 'dine-in' && $table) {
            $table->update(['status' => 'occupied']);
        }

        broadcast(new OrderPlaced($order))->toOthers();

        $this->completedOrder = $order;
        $this->showCheckout = false;
        $this->showSuccess = true;

        // Reset cart
        $this->cart = [];
        $this->selectedTableId = null;
        $this->customerName = '';
    }

    public function closeSuccess()
    {
        $this->showSuccess = false;
        $this->completedOrder = null;
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

    public function render()
    {
        $categories = Category::all();

        $menus = Menu::query();
        if ($this->activeCategoryId) {
            $menus->where('category_id', $this->activeCategoryId);
        }
        if ($this->search) {
            $menus->where('name', 'like', '%'.$this->search.'%');
        }

        $tables = Table::orderBy('table_number')->get();

        return view('livewire.cashier.pos-terminal', [
            'categories' => $categories,
            'menus' => $menus->get(),
            'tables' => $tables,
        ]);
    }
}
