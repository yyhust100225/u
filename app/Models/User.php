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
     * @return mixed 查询数据
     */
    public function data($page, $limit)
    {
        return $this->offset(($page - 1) * $limit)->limit($limit)->get();
    }

    /**
     * 查询数据总量
     * @return mixed
     */
    public function num()
    {
        return $this->count();
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
