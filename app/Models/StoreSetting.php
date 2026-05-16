<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreSetting extends Model
{
    protected $fillable = [
        'store_name',
        'store_address',
        'store_phone',
        'tax_rate',
        'service_charge_rate',
    ];
}
