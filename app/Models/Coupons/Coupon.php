<?php

namespace App\Models\Coupons;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order_amount',
        'max_discount',
        'usage_limit',
        'per_user_limit',
        'used_count',
        'start_date',
        'end_date',
        'applies_to',
        'product_ids',
        'category_ids',
        'is_active',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'product_ids' => 'array',
        'category_ids' => 'array',
        'is_active' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function usages()
    {
        return $this->hasMany(CouponUsage::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now());
    }

    public function isValid($subtotal = null)
    {
        if (!$this->is_active || now() < $this->start_date || now() > $this->end_date) {
            return false;
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        if ($subtotal && $this->min_order_amount > 0 && $subtotal < $this->min_order_amount) {
            return false;
        }

        return true;
    }

    public function calculateDiscount($subtotal)
    {
        if (!$this->isValid($subtotal)) {
            return 0;
        }

        $discount = 0;

        switch ($this->type) {
            case 'fixed':
                $discount = $this->value;
                break;
            case 'percentage':
                $discount = ($subtotal * $this->value) / 100;
                break;
            case 'free_shipping':
                return 0;
        }

        if ($this->max_discount && $discount > $this->max_discount) {
            $discount = $this->max_discount;
        }

        return $discount;
    }
}
