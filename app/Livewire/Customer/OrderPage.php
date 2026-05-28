<?php

namespace App\Livewire\Customer;

use App\Events\OrderPlaced;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\StoreSetting;
use App\Models\Table;
use Illuminate\Support\Str;
use Livewire\Component;

class OrderPage extends Component
{
    public $search = '';

    public $activeCategoryId = null;

    public $cart = [];

    public $table_id = null;

    public $customer_name = '';

    public $orderType = 'dine-in'; // 'dine-in' or 'takeaway'

    // Payment Options
    public $paymentMethod = 'cash'; // 'cash' or 'qris'

    public $showQrisModal = false;

    public $pendingOrder = null;

    // Success State
    public $showSuccess = false;

    public $completedOrder = null;

    // Cart Slide-over
    public $showCart = false;

    // Discount
    public $discountCode = '';

    public $appliedDiscount = null;

    public $discountError = null;

    // Set initial table based on URL param
    public $table_number = null;

    public function mount()
    {
        $this->table_number = request()->query('table');
        if ($this->table_number) {
            $table = Table::where('table_number', $this->table_number)
                ->orWhere('id', $this->table_number)
                ->first();
            if ($table) {
                $this->table_id = $table->id;
                if ($table->status === 'occupied') {
                    session()->flash('table_warning', 'Meja ini saat ini tercatat sedang terisi. Anda tetap bisa memesan, namun pesanan Anda mungkin akan digabung atau dikonfirmasi ulang oleh staf.');
                }
            }
        }
    }

    public function setActiveCategory($categoryId)
    {
        $this->activeCategoryId = $categoryId;
    }

    public function addToCart($menuId)
    {
        $menu = Menu::find($menuId);
        if (! $menu || $menu->isOutOfStock()) {
            return;
        }

        if (isset($this->cart[$menuId])) {
            if ($menu->track_stock && ($this->cart[$menuId]['quantity'] >= $menu->stock)) {
                return;
            }
            $this->cart[$menuId]['quantity']++;
        } else {
            $this->cart[$menuId] = [
                'id' => $menu->id,
                'name' => $menu->name,
                'price' => $menu->price,
                'quantity' => 1,
                'image' => $menu->image ? asset('storage/'.$menu->image) : null,
                'notes' => '',
            ];
        }
    }

    public function increaseQuantity($menuId)
    {
        if (isset($this->cart[$menuId])) {
            $menu = Menu::find($menuId);
            if ($menu && $menu->track_stock && ($this->cart[$menuId]['quantity'] >= $menu->stock)) {
                return;
            }
            $this->cart[$menuId]['quantity']++;
        }
    }

    public function decreaseQuantity($menuId)
    {
        if (isset($this->cart[$menuId])) {
            if ($this->cart[$menuId]['quantity'] > 1) {
                $this->cart[$menuId]['quantity']--;
            } else {
                unset($this->cart[$menuId]);
            }
        }

        if (empty($this->cart)) {
            $this->showCart = false;
        }
    }

    public function updateNotes($menuId, $notes)
    {
        if (isset($this->cart[$menuId])) {
            $this->cart[$menuId]['notes'] = $notes;
        }
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
    }

    public function getCartTotalProperty()
    {
        return collect($this->cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    public function getDiscountAmountProperty()
    {
        if (! $this->appliedDiscount) {
            return 0;
        }

        if ($this->appliedDiscount['type'] === 'percentage') {
            return $this->cartTotal * ($this->appliedDiscount['value'] / 100);
        }

        return min($this->appliedDiscount['value'], $this->cartTotal);
    }

    private $storeSetting = null;

    private function getStoreSetting()
    {
        if ($this->storeSetting === null) {
            $this->storeSetting = StoreSetting::first() ?? new StoreSetting();
        }
        return $this->storeSetting;
    }

    public function getTaxAmountProperty()
    {
        $setting = $this->getStoreSetting();
        $rate = $setting ? $setting->tax_rate : 0;
        $taxableAmount = $this->cartTotal - $this->discountAmount;

        return max(0, $taxableAmount * ($rate / 100));
    }

    public function getServiceChargeAmountProperty()
    {
        $setting = $this->getStoreSetting();
        $rate = $setting ? $setting->service_charge_rate : 0;
        $taxableAmount = $this->cartTotal - $this->discountAmount;

        return max(0, $taxableAmount * ($rate / 100));
    }

    public function getGrandTotalProperty()
    {
        return max(0, $this->cartTotal - $this->discountAmount + $this->taxAmount + $this->serviceChargeAmount);
    }

    public function checkout()
    {
        $rules = [
            'customer_name' => 'required|string|max:255',
            'orderType' => 'required|in:dine-in,takeaway',
        ];

        if ($this->orderType === 'dine-in') {
            $rules['table_id'] = 'required|exists:tables,id';
        }

        $this->validate($rules, [
            'customer_name.required' => 'Nama wajib diisi.',
            'table_id.required' => 'Silakan pilih nomor meja Anda.',
        ]);

        if (empty($this->cart)) {
            $this->addError('cart', 'Keranjang belanja masih kosong.');

            return;
        }

        if ($this->paymentMethod === 'qris') {
            // Show QRIS Modal and wait for simulated payment
            $this->showQrisModal = true;

            return;
        }

        // Cash Payment - Process immediately
        $this->processFinalOrder('cash', 'unpaid');
    }

    public function cancelQris()
    {
        $this->showQrisModal = false;
    }

    public function simulateQrisSuccess()
    {
        // Customer paid via QRIS
        $this->processFinalOrder('qris', 'paid');
        $this->showQrisModal = false;
    }

    private function processFinalOrder($method, $status)
    {
        $table = $this->orderType === 'dine-in' ? Table::find($this->table_id) : null;

        $queueType = $method === 'cash' ? 1 : 2;
        $queueNumber = Order::whereDate('created_at', today())->max('queue_number');
        $queueNumber = ($queueNumber ?? 0) + 1;

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
            'table_id' => $this->orderType === 'dine-in' ? $this->table_id : null,
            'customer_name' => $this->customer_name,
            'order_type' => $this->orderType,
            'status' => 'pending',
            'payment_status' => $status,
            'payment_method' => $method,
            'queue_type' => $queueType,
            'queue_number' => $queueNumber,
            'subtotal_price' => $this->cartTotal,
            'tax_amount' => $this->taxAmount,
            'service_charge_amount' => $this->serviceChargeAmount,
            'discount_amount' => $this->discountAmount,
            'discount_code' => $this->appliedDiscount['code'] ?? null,
            'total_price' => $this->grandTotal,
        ]);

        foreach ($this->cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'notes' => $item['notes'] ?? null,
            ]);

            // Kurangi stok menu jika tracking stok aktif
            $menu = Menu::find($item['id']);
            if ($menu) {
                $menu->deductStock($item['quantity']);
            }
        }

        if ($this->orderType === 'dine-in' && $table && $table->status !== 'occupied') {
            $table->update(['status' => 'occupied']);
        }

        // Fire event only after successful payment (or cash selection)
        // This triggers KDS real-time update
        broadcast(new OrderPlaced($order))->toOthers();

        // Update Discount Usage
        if ($this->appliedDiscount) {
            $discount = Discount::find($this->appliedDiscount['id']);
            if ($discount) {
                $discount->increment('used_count');
            }
        }

        // Save to session so dashboard can auto-load tracking
        session(['last_order_number' => $order->order_number]);

        // Clear cart and show success
        $this->completedOrder = $order;
        $this->cart = [];
        $this->showCart = false;
        $this->showSuccess = true;
        $this->appliedDiscount = null;
        $this->discountCode = '';
    }

    public function closeSuccess()
    {
        $orderNumber = $this->completedOrder->order_number;
        $this->showSuccess = false;
        $this->completedOrder = null;

        return redirect()->route('customer.track', ['order_number' => $orderNumber]);
    }

    public function render()
    {
        $categories = Category::withCount('menus')->orderBy('id')->get();

        $menus = Menu::query()
            ->select('menus.*')
            ->join('categories', 'menus.category_id', '=', 'categories.id')
            ->orderBy('categories.id')
            ->orderBy('menus.name');

        if ($this->activeCategoryId) {
            $menus->where('menus.category_id', $this->activeCategoryId);
        }
        if ($this->search) {
            $menus->where('menus.name', 'like', '%'.$this->search.'%');
        }

        $tables = Table::orderBy('table_number')->get();

        return view('livewire.customer.order-page', [
            'categories' => $categories,
            'menus' => $menus->get(),
            'tables' => $tables,
        ])->layout('layouts.customer');
    }
}
