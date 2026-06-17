<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'variant_type',
        'variant_value',
        'price_adjustment',
        'stock',
        'sku',
    ];

    protected $casts = [
        'price_adjustment' => 'decimal:2',
        'stock' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function cartItems()
    {
        return $this->hasMany(\App\Models\Customer\CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(\App\Models\Orders\OrderItem::class);
    }

    public function hasStock($quantity = 1)
    {
        return $this->stock >= $quantity;
    }

    public function decreaseStock($quantity = 1)
    {
        if ($this->hasStock($quantity)) {
            $this->decrement('stock', $quantity);
            return true;
        }
        return false;
    }
}
