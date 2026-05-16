<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'is_drink'  => 'boolean',
    ];

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}
