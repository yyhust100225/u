<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Common;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

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
     * @param $page integer 查询页
     * @param $limit integer 每页数据量
     * @param $with array|string 关联查询
     * @return mixed 查询数据
     */
    public function data($page, $limit, $with = '')
    {
        if($with == '')
            return $this->newQuery()->offset(($page - 1) * $limit)->limit($limit)->get();
        else
            return $this->with($with)->offset(($page - 1) * $limit)->limit($limit)->get();
    }

    /**
     * 查询数据总量
     * @return mixed
     */
    public function num()
    {
        return $this->newQuery()->count();
    }

    /**
     * 用户表唯一角色关联
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
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
            abort(404);
        }

        if($aim_permission->level == AUTHORIZATION_LEVEL_ALL_DENIED)
            return false;

        if($aim_permission->level == AUTHORIZATION_LEVEL_ALL_ALLOWED)
            return true;

        return !is_null($user->role->permissions->find($aim_permission->id));
    }
}
