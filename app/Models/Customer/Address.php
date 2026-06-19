<?php

namespace App\Models\Customer;

use App\Models\Auth\User;
use App\Models\Orders\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'type',
        'name',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'pincode',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shippingOrders()
    {
        return $this->hasMany(Order::class, 'shipping_address_id');
    }

    public function billingOrders()
    {
        return $this->hasMany(Order::class, 'billing_address_id');
    }

    // Scopes
    public function scopeShipping($query)
    {
        return $query->where('type', 'shipping');
    }

    public function scopeBilling($query)
    {
        return $query->where('type', 'billing');
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    // Accessors
    public function getFullAddressAttribute()
    {
        return "{$this->address}, {$this->city}, {$this->state}, {$this->country} - {$this->pincode}";
    }

    // Methods
    public function setAsDefault()
    {
        // Remove default from other addresses
        $this->user->addresses()->where('type', $this->type)->update(['is_default' => false]);

        $this->is_default = true;
        $this->save();
    }
}
