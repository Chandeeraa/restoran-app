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
use App\Models\Discount;
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

    // Discount Properties
    public $discountCode = '';

    public $appliedDiscount = null;

    public $discountError = null;

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

    public function handleTableClick($tableId)
    {
        $table = Table::find($tableId);
        if (!$table) return;

        if ($table->status === 'occupied') {
            if ($this->selectedTableId === $tableId) {
                $this->selectedTableId = null;
            } else {
                $table->status = 'available';
                $table->save();
            }
        } else {
            if ($this->activeTab === 'tables') {
                // In Table Map, clicking available table marks it as occupied
                $table->status = 'occupied';
                $table->save();
            } else {
                // In Menu tab, clicking available table selects it for the POS order
                if ($this->selectedTableId === $tableId) {
                    $this->selectedTableId = null; // Toggle off
                } else {
                    $this->selectedTableId = $tableId;
                }
            }
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

    private $storeSetting = null;

    private function getStoreSetting()
    {
        if ($this->storeSetting === null) {
            $this->storeSetting = StoreSetting::first() ?? new StoreSetting();
        }
        return $this->storeSetting;
    }

    public function getDiscountAmountProperty()
    {
        if (! $this->appliedDiscount) {
            return 0;
        }

        if ($this->appliedDiscount['type'] === 'percentage') {
            return $this->subtotal * ($this->appliedDiscount['value'] / 100);
        }

        return min($this->appliedDiscount['value'], $this->subtotal);
    }

    public function getTaxAmountProperty()
    {
        $settings = $this->getStoreSetting();
        $rate = $settings ? $settings->tax_rate : 0;
        $taxableAmount = max(0, $this->subtotal - $this->discountAmount);

        return $taxableAmount * ($rate / 100);
    }

    public function getServiceChargeAmountProperty()
    {
        $settings = $this->getStoreSetting();
        $rate = $settings ? $settings->service_charge_rate : 0;
        $taxableAmount = max(0, $this->subtotal - $this->discountAmount);

        return $taxableAmount * ($rate / 100);
    }

    public function getTotalProperty()
    {
        return max(0, $this->subtotal - $this->discountAmount + $this->taxAmount + $this->serviceChargeAmount);
    }

    public function applyDiscount()
    {
        $this->discountError = null;
        if (empty($this->discountCode)) {
            return;
        }

        $discount = Discount::where('code', strtoupper($this->discountCode))
            ->where('is_active', true)
            ->first();

        if (! $discount || ! $discount->isUsable()) {
            $this->discountError = 'Kode diskon tidak valid, sudah kadaluarsa, atau sudah habis kuota.';
            return;
        }

        $this->appliedDiscount = [
            'id' => $discount->id,
            'code' => $discount->code,
            'type' => $discount->type,
            'value' => $discount->value,
        ];
    }

    public function removeDiscount()
    {
        $this->appliedDiscount = null;
        $this->discountCode = '';
        $this->discountError = null;
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
        if (empty(trim($this->customerName))) {
            $this->paymentError = 'Nama pelanggan wajib diisi!';
            return;
        }

        if ($this->paymentMethod === 'cash') {
            if (empty($this->amountGiven) || $this->amountGiven < $this->total) {
                $this->paymentError = 'Amount given is less than total price.';

                return;
            }
        }

        $table = Table::find($this->selectedTableId);

        $queueType = $this->paymentMethod === 'cash' ? 1 : 2;
        $queueNumber = $this->getNextQueueNumber();

        // Better sequential order number
        $todayStr = now()->format('Ymd');
        $lastOrderToday = Order::whereDate('created_at', today())
            ->orderBy('id', 'desc')
            ->first();
        $nextSeq = 1;
        if ($lastOrderToday) {
            $parts = explode('-', $lastOrderToday->order_number);
            if (count($parts) === 3) {
                $nextSeq = intval($parts[2]) + 1;
            }
        }
        $orderNumber = 'ORD-' . $todayStr . '-' . str_pad($nextSeq, 4, '0', STR_PAD_LEFT);

        $order = Order::create([
            'order_number' => $orderNumber,
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
            'service_charge_amount' => $this->serviceChargeAmount,
            'discount_amount' => $this->discountAmount,
            'discount_code' => $this->appliedDiscount['code'] ?? null,
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

            // Kurangi stok menu jika tracking stok aktif
            $menu = Menu::find($item['id']);
            if ($menu) {
                $menu->deductStock($item['quantity']);
            }
        }

        if ($this->orderType === 'dine-in' && $table) {
            $table->update(['status' => 'occupied']);
        }

        broadcast(new OrderPlaced($order))->toOthers();

        // Increment discount used count
        if ($this->appliedDiscount) {
            $discount = Discount::find($this->appliedDiscount['id']);
            if ($discount) {
                $discount->increment('used_count');
            }
        }

        $this->completedOrder = $order;
        $this->showCheckout = false;
        $this->showSuccess = true;

        // Reset cart and discount
        $this->cart = [];
        $this->selectedTableId = null;
        $this->customerName = '';
        $this->appliedDiscount = null;
        $this->discountCode = '';
        $this->discountError = null;
    }

    public function closeSuccess()
    {
        $this->showSuccess = false;
        $this->completedOrder = null;
    }

    /**
     * Assign queue number sequentially for the day, regardless of payment method.
     */
    private function getNextQueueNumber(): int
    {
        $last = Order::whereDate('created_at', today())
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
