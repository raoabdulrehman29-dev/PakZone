<?php

namespace App\Models\Auth;

use App\Models\Customer\Cart;  // ← CHANGE THIS
use App\Models\Customer\Address;
use App\Models\Customer\Wishlist;
use App\Models\Customer\Review;
use App\Models\Orders\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    // ... rest of your code

    public function cart()
    {
        return $this->hasOne(Cart::class);  // ← FIXED
    }
}
