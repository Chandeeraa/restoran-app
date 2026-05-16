<?php

namespace App\Livewire\Admin;

use App\Models\Discount;
use Livewire\Component;

class DiscountManager extends Component
{
    public $code = '';
    public $description = '';
    public $type = 'percentage';
    public $value = '';
    public $max_uses = '';
    public $is_active = true;

    public $discountId = null;
    public $isEditMode = false;

    public function mount()
    {
        abort_if(auth()->user()->role !== 'admin', 403);
    }

    public function store()
    {
        $this->validate([
            'code'        => 'required|string|max:50|unique:discounts,code',
            'description' => 'nullable|string|max:255',
            'type'        => 'required|in:percentage,fixed',
            'value'       => 'required|numeric|min:0',
            'max_uses'    => 'nullable|integer|min:1',
            'is_active'   => 'boolean',
        ]);

        Discount::create([
            'code'        => strtoupper(trim($this->code)),
            'description' => $this->description,
            'type'        => $this->type,
            'value'       => $this->value,
            'max_uses'    => $this->max_uses ?: null,
            'is_active'   => $this->is_active,
        ]);

        $this->resetFields();
        session()->flash('message', 'Kode diskon berhasil dibuat!');
    }

    public function edit($id)
    {
        $discount = Discount::findOrFail($id);
        $this->discountId   = $discount->id;
        $this->code         = $discount->code;
        $this->description  = $discount->description;
        $this->type         = $discount->type;
        $this->value        = $discount->value;
        $this->max_uses     = $discount->max_uses;
        $this->is_active    = $discount->is_active;
        $this->isEditMode   = true;
    }

    public function update()
    {
        $this->validate([
            'code'        => 'required|string|max:50|unique:discounts,code,' . $this->discountId,
            'description' => 'nullable|string|max:255',
            'type'        => 'required|in:percentage,fixed',
            'value'       => 'required|numeric|min:0',
            'max_uses'    => 'nullable|integer|min:1',
            'is_active'   => 'boolean',
        ]);

        $discount = Discount::findOrFail($this->discountId);
        $discount->update([
            'code'        => strtoupper(trim($this->code)),
            'description' => $this->description,
            'type'        => $this->type,
            'value'       => $this->value,
            'max_uses'    => $this->max_uses ?: null,
            'is_active'   => $this->is_active,
        ]);

        $this->resetFields();
        session()->flash('message', 'Kode diskon berhasil diperbarui!');
    }

    public function delete($id)
    {
        Discount::findOrFail($id)->delete();
        session()->flash('message', 'Kode diskon dihapus.');
    }

    public function toggleActive($id)
    {
        $discount = Discount::findOrFail($id);
        $discount->update(['is_active' => !$discount->is_active]);
    }

    public function resetFields()
    {
        $this->code         = '';
        $this->description  = '';
        $this->type         = 'percentage';
        $this->value        = '';
        $this->max_uses     = '';
        $this->is_active    = true;
        $this->discountId   = null;
        $this->isEditMode   = false;
    }

    public function render()
    {
        return view('livewire.admin.discount-manager', [
            'discounts' => Discount::latest()->get(),
        ])->layout('layouts.app', ['header' => 'Discount Manager']);
    }
}
