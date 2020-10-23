<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Response;
use Illuminate\Notifications\Notifiable;
use App\Models\Common;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property int $role_id 角色ID
 * @property string $remark 备注
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Role $role
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\Models\Employee|null $archive
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * 查询用户列表数据
     * @param integer $page 查询页
     * @param integer $limit 每页数据量
     * @param array $where 查询条件
     * @param array|string $with 关联查询
     * @return mixed 查询数据
     */
    public function select($page, $limit, $where = array(), $with = '')
    {
        $model = $this->newQuery();

        foreach($where as $field => $value) {
            if(is_array($value))
                $model->where($field, $value[0], $value[1]);
            else
                $model->where($field, $value);
        }

        $return['count'] = $model->count();

        if($with == '')
            $return['data'] = $model->newQuery()->offset(($page - 1) * $limit)->limit($limit)->get();
        else
            $return['data'] = $model->with($with)->offset(($page - 1) * $limit)->limit($limit)->get();

        return $return;
    }

    /**
     * 判断用户是否有相应操作控制器方法权限
     * @param User $user
     * @param $controller
     * @param $action
     * @return bool
     */
    public function hasPrivilege(User $user, $controller, $action)
    {
        // 找不到指定路由
        if(!$aim_permission = Permission::query()->where('controller', $controller)->where('action', $action)->first()) {
            abort(404, trans('auth.empty authority'));
        }

        if($aim_permission->level == AUTHORIZATION_LEVEL_ALL_DENIED)
            return false;

        if($aim_permission->level == AUTHORIZATION_LEVEL_ALL_ALLOWED)
            return true;

        return !is_null($user->role->permissions->find($aim_permission->id));
    }

    /**
     * 用户表唯一角色关联
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    // 关联员工档案表
    public function archive()
    {
        return $this->hasOne(Employee::class, 'user_id');
    }
}
