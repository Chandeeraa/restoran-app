<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_available'        => 'boolean',
        'is_best_seller'      => 'boolean',
        'track_stock'         => 'boolean',
        'stock'               => 'integer',
        'low_stock_threshold' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /** Stok menipis (di bawah threshold, tapi belum habis) */
    public function isLowStock(): bool
    {
        return $this->track_stock && $this->stock > 0 && $this->stock <= $this->low_stock_threshold;
    }

    /** Stok habis */
    public function isOutOfStock(): bool
    {
        return $this->track_stock && $this->stock <= 0;
    }

    /**
     * Kurangi stok sejumlah $qty.
     * Jika stok habis → nonaktifkan menu otomatis.
     */
    public function deductStock(int $qty): void
    {
        if (!$this->track_stock) return;

        $newStock = max(0, $this->stock - $qty);
        $this->stock = $newStock;

        if ($newStock <= 0) {
            $this->is_available = false;
        }

        $this->save();
    }
}
