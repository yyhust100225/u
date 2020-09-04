<?php

namespace App\Models\Maps;

use App\Models\Common;
use Illuminate\Support\Facades\DB;

class MapRoleToPermissions extends Common
{
    // 保存角色和权限映射
    public function saveRoleToPermissions($role_id, $permissions)
    {
        $role_to_permissions = [];
        foreach($permissions as $permission) {
            $role_to_permissions[] = ['role_id' => $role_id, 'permission_id' => $permission];
        }

        return DB::table($this->getTable())->where('role_id', $role_id)->delete() !== false && DB::table($this->getTable())->insert($role_to_permissions);
    }
}
