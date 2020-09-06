<?php

namespace App\Models;

use App\Models\Maps\MapRoleToPermissions;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Gate;

class Role extends Common
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'status', 'remark'
    ];

    // 关联获取角色所有权限模型
    public function permissions()
    {
        return $this->hasManyThrough(Permission::class,MapRoleToPermissions::class, 'role_id', 'id', 'id', 'permission_id');
    }

    // 关联获取角色所有权限ID
    public function permissionIds()
    {
        return $this->hasMany(MapRoleToPermissions::class, 'role_id', 'id');
    }

    // 查询可用状态角色数据
    public function roles($fields = ['id', 'name'])
    {
        return $this->where('status', 1)->get($fields);
    }
}
