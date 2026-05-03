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

    public function mount()
    {
        $this->tables = Table::where('status', 'available')->get();

        if (request()->has('table')) {
            $table = Table::find(request()->query('table'));
            if ($table) {
                $this->table_id = $table->id;
                $this->table_number = $table->table_number;
                $this->orderType = 'dine-in';
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

        $order = Order::create([
            'table_id'      => $this->table_id,
            'order_number'  => 'ORD-' . strtoupper(Str::random(8)),
            'customer_name' => trim($this->customer_name),
            'order_type'    => $this->orderType,
            'status'        => 'pending',
            'total_price'   => $this->cartTotal,
            'payment_status'=> 'unpaid',
        ]);

        foreach ($this->cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $item['menu_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'notes' => $item['notes'] ?? '',
            ]);
        }

        if ($this->table_id) {
            Table::where('id', $this->table_id)->update(['status' => 'occupied']);
        }

        // Broadcast the new order to the Kitchen Display System
        event(new \App\Events\OrderPlaced($order));

        $this->cart = [];
        $this->showCart = false;

        return redirect()->route('customer.track', ['order_number' => $order->order_number]);
    }

    public function render()
    {
        return view('livewire.customer.order-page')->layout('layouts.customer');
    }
}
