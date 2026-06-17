<?php

namespace App\Policies;

use App\Models\Auth\User as AuthUser;
use App\Models\Products\Product;
use App\Models\Auth\User;

class ProductPolicy
{
    /**
     * Create a new policy instance.
     */

  public function viewAny(User $user)
  {
    return true;
  }
  public function view(User $user,Product $product)
  {
    return true;
  }
  public function create(User $user)
  {
    return $user->hasRole(['admin','super_admin','mmanager']);

  }
  public function update(User $user,Product $product,)
  {
    return $user->hasRole(['super_admin','admin','manager']);
  }
  public function delete(User $user,Product $product)
  {
    return $user->hasrole(['admin','super_admin']);
  }
  public function restore(User $user,Product $product)
  {
    return $user->hasRole(['admin','super_admin']);
  }
  public function forceDelete(User $user,Product $product)

  {
    return $user->hasRole('super_admin');
  }
    public function __construct()
    {
        //
    }
}
