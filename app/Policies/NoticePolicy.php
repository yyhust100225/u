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

    // 提交已发布要讯权限
    public function commit(User $user)
    {
        return $this->publish($user);
    }

    // 撤回提交状态要讯权限
    public function withdraw(User $user)
    {
        return $this->publish($user);
    }

    // 创建新要讯权限
    public function create(User $user)
    {
        return $this->publish($user);
    }

    // 审查要讯公告权限
    public function reviews(User $user)
    {
        return $this->checkAuthorization($user, 'reviews');
    }

    // 获取要审核要讯
    public function reviewsData(User $user)
    {
        return $this->reviews($user);
    }

    // 查看要讯
    public function show(User $user)
    {
        return $this->reviews($user);
    }

    // 要讯审核通过
    public function approve(User $user)
    {
        return $this->reviews($user);
    }

    // 要讯审核驳回
    public function reject(User $user)
    {
        return $this->reviews($user);
    }
}
