<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
        'code',
        'description',
        'type',
        'value',
        'max_uses',
        'used_count',
        'is_active',
        'valid_until',
    ];

    protected $casts = [
        'valid_until' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Calculate the discount amount based on a subtotal.
     */
    public function calculateDiscount(float $subtotal): float
    {
        if ($this->type === 'percentage') {
            return $subtotal * ($this->value / 100);
        }

        // Fixed amount, but cannot exceed subtotal
        return min($this->value, $subtotal);
    }

    /**
     * Check if this discount code can still be used.
     */
    public function isUsable(): bool
    {
        if (! $this->is_active) {
            return false;
        }
        if ($this->valid_until !== null && $this->valid_until->isPast()) {
            return false;
        }
        if ($this->max_uses !== null && $this->used_count >= $this->max_uses) {
            return false;
        }

        return true;
    }
}
