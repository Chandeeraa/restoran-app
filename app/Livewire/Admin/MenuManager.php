<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Menu;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class MenuManager extends Component
{
    use WithFileUploads, WithPagination;

    public $name = '';

    public $description = '';

    public $price = '';

    public $image;

    public $existingImage = '';

    public $is_available = true;

    public $is_best_seller = false;

    public $category_id = '';

    public $menuId = null;

    public $isEditMode = false;

    // Stock management
    public $track_stock = false;

    public $stock = 0;

    public $low_stock_threshold = 5;

    // Quick stock edit
    public $editingStockId = null;

    public $quickStockValue = 0;

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_available' => 'boolean',
            'is_best_seller' => 'boolean',
        ]);

        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('menus', 'public');
        }

        Menu::create([
            'name' => $this->name,
            'category_id' => $this->category_id,
            'price' => $this->price,
            'description' => $this->description,
            'image' => $imagePath,
            'is_available' => $this->is_available,
            'is_best_seller' => $this->is_best_seller,
            'track_stock' => $this->track_stock,
            'stock' => $this->track_stock ? (int) $this->stock : 0,
            'low_stock_threshold' => (int) $this->low_stock_threshold,
        ]);

        $this->resetFields();
        session()->flash('message', 'Menu created successfully.');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $this->menuId = $menu->id;
        $this->name = $menu->name;
        $this->category_id = $menu->category_id;
        $this->price = $menu->price;
        $this->description = $menu->description;
        $this->existingImage = $menu->image;
        $this->is_available = $menu->is_available;
        $this->is_best_seller = $menu->is_best_seller;
        $this->track_stock = $menu->track_stock;
        $this->stock = $menu->stock;
        $this->low_stock_threshold = $menu->low_stock_threshold;
        $this->isEditMode = true;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_available' => 'boolean',
            'is_best_seller' => 'boolean',
        ]);

        $menu = Menu::findOrFail($this->menuId);

        $imagePath = $menu->image;
        if ($this->image) {
            $imagePath = $this->image->store('menus', 'public');
        }

        $menu->update([
            'name' => $this->name,
            'category_id' => $this->category_id,
            'price' => $this->price,
            'description' => $this->description,
            'image' => $imagePath,
            'is_available' => $this->is_available,
            'is_best_seller' => $this->is_best_seller,
            'track_stock' => $this->track_stock,
            'stock' => $this->track_stock ? (int) $this->stock : 0,
            'low_stock_threshold' => (int) $this->low_stock_threshold,
        ]);

        $this->resetFields();
        session()->flash('message', 'Menu updated successfully.');
    }

    public function delete($id)
    {
        Menu::findOrFail($id)->delete();
        session()->flash('message', 'Menu deleted successfully.');
    }

    public function toggleAvailability($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->update(['is_available' => ! $menu->is_available]);
        session()->flash('message', 'Status menu "'.$menu->name.'" berhasil diubah.');
    }

    public function toggleBestSeller($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->update(['is_best_seller' => ! $menu->is_best_seller]);
    }

    /** Buka inline quick-stock editor untuk menu tertentu */
    public function openStockEdit($id)
    {
        $menu = Menu::findOrFail($id);
        $this->editingStockId = $id;
        $this->quickStockValue = $menu->stock;
    }

    /** Simpan perubahan stok dari inline editor */
    public function saveStock($id)
    {
        $this->validate(['quickStockValue' => 'required|integer|min:0']);
        $menu = Menu::findOrFail($id);
        $menu->stock = (int) $this->quickStockValue;
        // Jika stok diisi > 0 dan menu sedang nonaktif karena stok habis, aktifkan kembali
        if ($menu->track_stock && $menu->stock > 0 && ! $menu->is_available) {
            $menu->is_available = true;
        }
        $menu->save();
        $this->editingStockId = null;
        session()->flash('message', 'Stok "'.$menu->name.'" diperbarui menjadi '.$menu->stock.'.');
    }

    public function cancelStockEdit()
    {
        $this->editingStockId = null;
    }

    public function resetFields()
    {
        $this->name = '';
        $this->category_id = '';
        $this->price = '';
        $this->description = '';
        $this->image = null;
        $this->existingImage = '';
        $this->is_available = true;
        $this->is_best_seller = false;
        $this->track_stock = false;
        $this->stock = 0;
        $this->low_stock_threshold = 5;
        $this->menuId = null;
        $this->isEditMode = false;
        $this->editingStockId = null;
    }

    public function render()
    {
        return view('livewire.admin.menu-manager', [
            'menus' => Menu::with('category')->paginate(10),
            'categories' => Category::all(),
            'lowStockMenus' => Menu::where('track_stock', true)
                ->whereRaw('stock > 0 AND stock <= low_stock_threshold')
                ->get(),
        ])->layout('layouts.app');
    }
}
