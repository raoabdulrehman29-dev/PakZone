<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, Hasfactory, SoftDeletes, Notifiable, HasRoles;

    protected $fillable=[
        'name',
        'email',
        'password',
        'phone',
        'avater',
        'role_id',
        'atatus',
        'email_verified_at',
        'phone_verified_at',
    ];
    protected $hidden=[
        'password',
        'remember_token',
    ];
    protected $casts=[
        'email_verified_at' =>'datetime',
        'phone_verified_at' => 'datetime',

    ];

    public function Addresses()
    {
        return $this->hasMany(Address::class);
    }
     public function Orders()
     {
        return $this->hasMany(Order::class);
     }
     public function cart()
     {
        return $this->hasMany(Cart::class);
     }
     public function wishlists()
     {
        return $this->hasMany(Wishlist::class);
     }
     public function reviews()
     {
        return $this->hasMany(Review::class);
     }
     public function notificationPreference()
     {
        return $this->hasMany(NotificationPrefrence::class);;
     }

     //Scopes
     public function scopeActive($query)
     {
        $query->where('status','active');
     }
    public function  scopeCustomers($query){
        return $query->whereHas('role',function($q){
         $q->where('name','customer');
        });
    }
    public function scopeAdmin($query){
        return $query->whereHas('role',function($q)
        {
            $q->whereIn('name',['admin','super_admin']);
        });
    }
public function getFulllNameAttribute(){
return $this->name;
}
public function getIsAdminAttribute()
{
    return $this->hasRole(['admin','super_admin']);
}

public function setPasswordAttributes($value){
    return $this->attributes['password']=bcrypt($value);
}
//mehtods
public function hasPermissions($permissions){
    return $this->role?->permissions->contains('name',$permissions) ?? false;
}

public function getCart()
{
    return $this->cart()->firstOrCreate('status','active');

}
public function wishlist()
{
    return $this->wishlists()->count();
}
public function getOrderCount(){
    return  $this->orders()->count();

}
public function getTotalSpent(){
    return $this->orders()->where('status','delivered')->sum('total_amount');
}



}
