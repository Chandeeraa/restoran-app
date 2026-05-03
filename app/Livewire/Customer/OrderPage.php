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

    public function mount()
    {
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
        if ($this->categories->count() > 0) {
            $this->activeCategoryId = $this->categories->first()->id;
        }

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
        
        $this->showCart = true;
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

        $order = Order::create([
            'table_id' => $this->table_id,
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'order_type' => $this->orderType,
            'status' => 'pending',
            'total_price' => $this->cartTotal,
            'payment_status' => 'unpaid',
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

        session()->flash('success_order', 'Pesanan Anda (' . $order->order_number . ') berhasil dikirim ke dapur!');
    }

    public function render()
    {
        return view('livewire.customer.order-page')->layout('layouts.customer');
    }
}
