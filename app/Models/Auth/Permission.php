<?php

namespace App\Models\Auth;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
     public function scopeWeb($query)
    {
        return $query->where('guard_name', 'web');
    }
}
