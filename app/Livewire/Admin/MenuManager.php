<?php

namespace App\Livewire\Admin;

use App\Models\Menu;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class MenuManager extends Component
{
    use WithPagination, WithFileUploads;

    public $name = '';
    public $description = '';
    public $price = '';
    public $image;
    public $existingImage = '';
    public $is_available = true;
    public $category_id = '';
    public $menuId = null;
    public $isEditMode = false;

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_available' => 'boolean',
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
        ]);

        $this->resetFields();
        session()->flash('message', 'Menu updated successfully.');
    }

    public function delete($id)
    {
        Menu::findOrFail($id)->delete();
        session()->flash('message', 'Menu deleted successfully.');
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
        $this->menuId = null;
        $this->isEditMode = false;
    }

    public function render()
    {
        return view('livewire.admin.menu-manager', [
            'menus' => Menu::with('category')->paginate(10),
            'categories' => Category::where('is_active', true)->get()
        ])->layout('layouts.app');
    }
}
