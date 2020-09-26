<?php

namespace App\Models\Maps;

use App\Models\Common;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\Maps\MapRoleToPermissions
 *
 * @property int $id
 * @property int $role_id 角色ID
 * @property int $permission_id 权限ID
 * @method static \Illuminate\Database\Eloquent\Builder|MapRoleToPermissions newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MapRoleToPermissions newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MapRoleToPermissions query()
 * @method static \Illuminate\Database\Eloquent\Builder|MapRoleToPermissions whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MapRoleToPermissions wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MapRoleToPermissions whereRoleId($value)
 * @mixin \Eloquent
 */
class MapRoleToPermissions extends Common
{
    // 保存角色和权限映射
    public function saveRoleToPermissions($role_id, $permissions)
    {
        if(is_null($permissions)) return false;

        $role_to_permissions = [];
        foreach($permissions as $permission) {
            $role_to_permissions[] = ['role_id' => $role_id, 'permission_id' => $permission];
        }

        return DB::table($this->getTable())->where('role_id', $role_id)->delete() !== false && DB::table($this->getTable())->insert($role_to_permissions);
    }
}
