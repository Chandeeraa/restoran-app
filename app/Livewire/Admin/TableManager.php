<?php

namespace App\Livewire\Admin;

use App\Models\Table;
use Livewire\Component;
use Livewire\WithPagination;

class TableManager extends Component
{
    use WithPagination;

    public $table_number = '';
    public $status = 'available';
    public $tableId = null;
    public $isEditMode = false;

    public function store()
    {
        $this->validate([
            'table_number' => 'required|string|max:255|unique:tables,table_number',
            'status' => 'required|in:available,occupied',
        ]);

        $table = Table::create([
            'table_number' => $this->table_number,
            'status' => $this->status,
        ]);

        $url = route('order', ['table' => $table->id]);
        $table->update([
            'qr_code' => $url
        ]);

        $this->resetFields();
        session()->flash('message', 'Table created successfully.');
    }

    public function edit($id)
    {
        $table = Table::findOrFail($id);
        $this->tableId = $table->id;
        $this->table_number = $table->table_number;
        $this->status = $table->status;
        $this->isEditMode = true;
    }

    public function update()
    {
        $this->validate([
            'table_number' => 'required|string|max:255|unique:tables,table_number,' . $this->tableId,
            'status' => 'required|in:available,occupied',
        ]);

        $table = Table::findOrFail($this->tableId);
        $table->update([
            'table_number' => $this->table_number,
            'status' => $this->status,
        ]);

        $this->resetFields();
        session()->flash('message', 'Table updated successfully.');
    }

    public function delete($id)
    {
        Table::findOrFail($id)->delete();
        session()->flash('message', 'Table deleted successfully.');
    }

    public function resetFields()
    {
        $this->table_number = '';
        $this->status = 'available';
        $this->tableId = null;
        $this->isEditMode = false;
    }

    public function render()
    {
        return view('livewire.admin.table-manager', [
            'tables' => Table::paginate(10)
        ])->layout('layouts.app');
    }
}
