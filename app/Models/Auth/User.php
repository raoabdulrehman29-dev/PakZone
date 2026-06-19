<?php

namespace App\Models\Auth;

// ✅ IMPORTS - Make sure all of these are present
use App\Models\Customer\Address;
use App\Models\Customer\Cart;
use App\Models\Customer\Wishlist;
use App\Models\Customer\Review;
use App\Models\Orders\Order;
use App\Models\Payments\Payment;
use App\Models\Notifications\NotificationPreference;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'avatar',
        'role_id',
        'status',
        'email_verified_at',
        'phone_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];

    // ============================================
    // ✅ RELATIONSHIPS - All Correct
    // ============================================

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function notificationPreference()
    {
        return $this->hasOne(NotificationPreference::class);
    }

    // ============================================
    // ✅ SCOPES
    // ============================================

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCustomers($query)
    {
        return $query->whereHas('role', function ($q) {
            $q->where('name', 'customer');
        });
    }

    public function scopeAdmins($query)
    {
        return $query->whereHas('role', function ($q) {
            $q->whereIn('name', ['super_admin', 'admin']);
        });
    }

    // ============================================
    // ✅ ACCESSORS & MUTATORS
    // ============================================

    public function getFullNameAttribute()
    {
        return $this->name;
    }

    public function getIsAdminAttribute()
    {
        return $this->hasRole(['super_admin', 'admin']);
    }

    public function getInitialsAttribute()
    {
        if (!$this->name) return '';
        $words = explode(' ', $this->name);
        $initials = '';
        foreach ($words as $word) {
            $initials .= strtoupper($word[0]);
        }
        return substr($initials, 0, 2);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    // ============================================
    // ✅ METHODS
    // ============================================

    public function hasPermission($permission)
    {
        return $this->role?->permissions->contains('name', $permission) ?? false;
    }

    public function getCart()
    {
        return $this->cart()->firstOrCreate(['status' => 'active']);
    }

    public function getWishlistCount()
    {
        return $this->wishlists()->count();
    }

    public function getOrderCount()
    {
        return $this->orders()->count();
    }

    public function getTotalSpent()
    {
        return $this->orders()
            ->where('status', 'delivered')
            ->sum('total_amount');
    }
}
