<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;
use App\Models\User;

class NoticePolicy extends CommonPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    // 发布要讯权限
    public function publish(User $user)
    {
        return $this->checkAuthorization($user, 'publish');
    }

    // 获取已发布要讯数据
    public function publishData(User $user)
    {
        return $this->publish($user);
    }

    // 创建新要讯权限
    public function create(User $user)
    {
        return $this->publish($user);
    }
}
