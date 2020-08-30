<?php

namespace App\Models;

use App\Models\Maps\MapRoleToPermissions;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Gate;

class Role extends Common
{
    use SoftDeletes;

    public function permissions()
    {
        return $this->hasManyThrough(Permission::class,MapRoleToPermissions::class, 'role_id', 'id', 'id', 'permission_id');
    }
}
