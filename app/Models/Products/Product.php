<?php

namespace App\Models\Products;

// ✅ IMPORT ALL MODELS AT THE TOP
use App\Models\Customer\Review;
use App\Models\Customer\CartItem;
use App\Models\Customer\Wishlist;
use App\Models\Orders\OrderItem;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'sale_price',
        'sku',
        'stock',
        'low_stock_threshold',
        'category_id',
        'brand_id',
        'featured',
        'best_seller',
        'status',
        'seo_title',
        'seo_description',
        'views',
        'rating',
        'reviews_count',
        'weight',
        'dimensions',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'featured' => 'boolean',
        'best_seller' => 'boolean',
        'views' => 'integer',
        'stock' => 'integer',
        'rating' => 'decimal:2',
        'reviews_count' => 'integer',
    ];

    // ============================================
    // RELATIONSHIPS
    // ============================================

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
    

    // ============================================
    // SCOPES
    // ============================================

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeBestSeller($query)
    {
        return $query->where('best_seller', true);
    }

    // ============================================
    // ACCESSORS
    // ============================================

    public function getFinalPriceAttribute()
    {
        return $this->sale_price ?? $this->price;
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->sale_price && $this->price > 0) {
            return round((($this->price - $this->sale_price) / $this->price) * 100);
        }
        return 0;
    }

    public function getIsInStockAttribute()
    {
        return $this->stock > 0;
    }

    public function getIsLowStockAttribute()
    {
        return $this->stock <= $this->low_stock_threshold && $this->stock > 0;
    }

    // ============================================
    // METHODS
    // ============================================

    public function increaseViews()
    {
        $this->increment('views');
    }

    public function updateRating()
    {
        $this->rating = $this->reviews()->approved()->avg('rating') ?? 0;
        $this->reviews_count = $this->reviews()->approved()->count();
        $this->save();
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

    public function increaseStock($quantity = 1)
    {
        $this->increment('stock', $quantity);
        return true;
    }
}
