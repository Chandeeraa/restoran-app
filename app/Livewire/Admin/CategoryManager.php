<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryManager extends Component
{
    use WithPagination;

    public $name = '';

    public $slug = '';

    public $is_active = true;

    public $is_drink = false;

    public $categoryId = null;

    public $isEditMode = false;

    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'is_active' => 'boolean',
        ]);

        Category::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'is_active' => $this->is_active,
            'is_drink' => $this->is_drink,
        ]);

        $this->resetFields();
        session()->flash('message', 'Category created successfully.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->is_active = $category->is_active;
        $this->is_drink = $category->is_drink;
        $this->isEditMode = true;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,'.$this->categoryId,
            'is_active' => 'boolean',
        ]);

        $category = Category::findOrFail($this->categoryId);
        $category->update([
            'name' => $this->name,
            'slug' => $this->slug,
            'is_active' => $this->is_active,
            'is_drink' => $this->is_drink,
        ]);

        $this->resetFields();
        session()->flash('message', 'Category updated successfully.');
    }

    public function delete($id)
    {
        Category::findOrFail($id)->delete();
        session()->flash('message', 'Category deleted successfully.');
    }

    public function resetFields()
    {
        $this->name = '';
        $this->slug = '';
        $this->is_active = true;
        $this->is_drink = false;
        $this->categoryId = null;
        $this->isEditMode = false;
    }

    public function render()
    {
        return view('livewire.admin.category-manager', [
            'categories' => Category::paginate(10),
        ])->layout('layouts.app');
    }
}
