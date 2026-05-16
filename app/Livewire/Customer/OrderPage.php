<?php

namespace App\Livewire\Customer;

use App\Models\Menu;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Table;
use Livewire\Component;
use Illuminate\Support\Str;

class OrderPage extends Component
{
    public $table_id = null;
    public $table_number = null;
    public $categories = [];
    public $menus = [];
    public $activeCategoryId = null;
    
    public $cart = [];
    public $showCart = false;
    public $orderType = 'dine-in';
    public $customer_name = '';
    public $tables = [];

    // Discount
    public $discountCode = '';
    public $appliedDiscount = null;
    public $discountError = '';
    public $discountSuccess = '';

    public function mount()
    {
        $this->tables = Table::where('status', 'available')->get();

        if (request()->has('table')) {
            $table = Table::find(request()->query('table'));
            if ($table && $table->status === 'available') {
                $this->table_id = $table->id;
                $this->table_number = $table->table_number;
                $this->orderType = 'dine-in';
            } else {
                // Table is occupied or not found, fallback to takeaway
                $this->orderType = 'takeaway';
                session()->flash('table_warning', 'Meja yang Anda tuju sedang terisi. Silakan pilih mode Takeaway atau pilih meja lain.');
            }
        } else {
            $this->orderType = 'takeaway';
        }

        $this->categories = Category::where('is_active', true)->get();

        $this->loadMenus();
    }

    public function loadMenus()
    {
        $query = Menu::where('is_available', true);
        if ($this->activeCategoryId) {
            $query->where('category_id', $this->activeCategoryId);
        }
        $this->menus = $query->get();
    }

    public function setActiveCategory($id)
    {
        $this->activeCategoryId = $id;
        $this->loadMenus();
    }

    public function addToCart($menuId)
    {
        $menu = Menu::find($menuId);
        if (!$menu) return;

        if (isset($this->cart[$menuId])) {
            $this->cart[$menuId]['quantity']++;
        } else {
            $this->cart[$menuId] = [
                'menu_id' => $menu->id,
                'name' => $menu->name,
                'price' => $menu->price,
                'image' => $menu->image,
                'quantity' => 1,
                'notes' => '',
            ];
        }
    }

    public function increaseQuantity($menuId)
    {
        if (isset($this->cart[$menuId])) {
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

    public function toggleCart()
    {
        $this->showCart = !$this->showCart;
    }

    public function getCartTotalProperty()
    {
        $total = 0;
        foreach ($this->cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    public function getTaxAmountProperty()
    {
        $setting = \App\Models\StoreSetting::first();
        $rate = $setting ? (float) $setting->tax_rate : 0;
        return $this->cartTotal * ($rate / 100);
    }

    public function getServiceChargeAmountProperty()
    {
        $setting = \App\Models\StoreSetting::first();
        $rate = $setting ? (float) $setting->service_charge_rate : 0;
        return $this->cartTotal * ($rate / 100);
    }

    public function getDiscountAmountProperty()
    {
        if (!$this->appliedDiscount) return 0;
        $discount = \App\Models\Discount::find($this->appliedDiscount['id']);
        if (!$discount) return 0;
        return $discount->calculateDiscount($this->cartTotal);
    }

    public function getGrandTotalProperty()
    {
        return max(0, $this->cartTotal + $this->taxAmount + $this->serviceChargeAmount - $this->discountAmount);
    }

    public function applyDiscount()
    {
        $this->discountError = '';
        $this->discountSuccess = '';

        if (empty(trim($this->discountCode))) {
            $this->discountError = 'Masukkan kode promo terlebih dahulu.';
            return;
        }

        $discount = \App\Models\Discount::where('code', strtoupper(trim($this->discountCode)))->first();

        if (!$discount) {
            $this->discountError = 'Kode promo tidak ditemukan.';
            return;
        }

        if (!$discount->isUsable()) {
            $this->discountError = 'Kode promo ini sudah tidak aktif atau sudah habis masa berlakunya.';
            return;
        }

        $this->appliedDiscount = ['id' => $discount->id, 'code' => $discount->code, 'type' => $discount->type, 'value' => $discount->value];
        $this->discountSuccess = 'Kode promo "' . $discount->code . '" berhasil diterapkan!';
        $this->discountCode = '';
    }

    public function removeDiscount()
    {
        $this->appliedDiscount = null;
        $this->discountCode = '';
        $this->discountError = '';
        $this->discountSuccess = '';
    }

    public function checkout()
    {
        if (empty($this->cart)) return;

        if (empty(trim($this->customer_name))) {
            $this->addError('customer_name', 'Nama pemesan wajib diisi.');
            return;
        }

        if ($this->orderType === 'dine-in' && empty($this->table_id)) {
            $this->addError('table_id', 'Silakan pilih nomor meja Anda terlebih dahulu.');
            return;
        }

        // Validasi stok mencukupi sebelum checkout
        foreach ($this->cart as $item) {
            $menu = Menu::find($item['menu_id']);
            if ($menu && $menu->track_stock && $menu->stock < $item['quantity']) {
                $this->addError('customer_name',
                    "Stok \"" . $menu->name . "\" tidak mencukupi (sisa: " . $menu->stock . ").");
                return;
            }
        }

        $order = Order::create([
            'table_id'      => $this->table_id,
            'order_number'  => 'ORD-' . strtoupper(Str::random(8)),
            'customer_name' => trim($this->customer_name),
            'order_type'    => $this->orderType,
            'status'        => 'pending',
            'subtotal_price'=> $this->cartTotal,
            'tax_amount'    => $this->taxAmount,
            'service_charge_amount' => $this->serviceChargeAmount,
            'discount_code'  => $this->appliedDiscount['code'] ?? null,
            'discount_amount'=> $this->discountAmount,
            'total_price'   => $this->grandTotal,
            'payment_status'=> 'unpaid',
        ]);

        // Increment discount usage counter
        if ($this->appliedDiscount) {
            \App\Models\Discount::where('id', $this->appliedDiscount['id'])->increment('used_count');
        }

        foreach ($this->cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_id'  => $item['menu_id'],
                'quantity' => $item['quantity'],
                'price'    => $item['price'],
                'notes'    => $item['notes'] ?? '',
            ]);

            // Kurangi stok menu secara otomatis
            $menu = Menu::find($item['menu_id']);
            if ($menu) {
                $menu->deductStock($item['quantity']);
            }
        }

        if ($this->table_id) {
            Table::where('id', $this->table_id)->update(['status' => 'occupied']);
        }

        // Broadcast ke Kitchen (dibungkus try-catch agar tidak block redirect jika broadcasting tidak aktif)
        try {
            event(new \App\Events\OrderPlaced($order));
        } catch (\Exception $e) {
            \Log::warning('OrderPlaced broadcast failed: ' . $e->getMessage());
        }

        // Reset state
        $this->cart              = [];
        $this->showCart          = false;
        $this->appliedDiscount   = null;
        $this->discountCode      = '';
        $this->discountAmount    = 0;
        $this->discountError     = '';
        $this->discountSuccess   = '';

        return redirect()->route('customer.track', ['order_number' => $order->order_number]);
    }

    public function render()
    {
        return view('livewire.customer.order-page')->layout('layouts.customer');
    }
}
