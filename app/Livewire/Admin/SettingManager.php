<?php

namespace App\Livewire\Admin;

use App\Models\StoreSetting;
use Livewire\Component;

class SettingManager extends Component
{
    public $store_name = '';

    public $store_address = '';

    public $store_phone = '';

    public $tax_rate = 0;

    public $service_charge_rate = 0;

    public function mount()
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $setting = StoreSetting::firstOrCreate(
            ['id' => 1],
            [
                'store_name' => 'Restoran App',
                'store_address' => '',
                'store_phone' => '',
                'tax_rate' => 0,
                'service_charge_rate' => 0,
            ]
        );

        $this->store_name = $setting->store_name;
        $this->store_address = $setting->store_address;
        $this->store_phone = $setting->store_phone;
        $this->tax_rate = (float) $setting->tax_rate;
        $this->service_charge_rate = (float) $setting->service_charge_rate;
    }

    public function save()
    {
        $this->validate([
            'store_name' => 'required|string|max:255',
            'store_address' => 'nullable|string',
            'store_phone' => 'nullable|string|max:50',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'service_charge_rate' => 'required|numeric|min:0|max:100',
        ]);

        $setting = StoreSetting::first();
        $setting->update([
            'store_name' => $this->store_name,
            'store_address' => $this->store_address,
            'store_phone' => $this->store_phone,
            'tax_rate' => $this->tax_rate,
            'service_charge_rate' => $this->service_charge_rate,
        ]);

        session()->flash('message', 'Store settings updated successfully.');
    }

    public function render()
    {
        return view('livewire.admin.setting-manager')->layout('layouts.app', ['header' => 'Store Settings']);
    }
}
