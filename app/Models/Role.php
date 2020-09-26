<?php

namespace App\Models;

use App\Models\Maps\MapRoleToPermissions;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Gate;

/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name 角色名称
 * @property int $status 角色状态
 * @property string $remark 角色备注
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|MapRoleToPermissions[] $permissionIds
 * @property-read int|null $permission_ids_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Query\Builder|Role onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Role withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Role withoutTrashed()
 * @mixin \Eloquent
 */
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
