<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;

class ClassAnnouncementPolicy extends CommonPolicy
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

    // 创建开版公告权限
    public function create(User $user)
    {
        return $this->list($user);
    }

    // 编辑开版公告权限
    public function edit(User $user)
    {
        return $this->list($user);
    }

    // 删除开版公告权限
    public function delete(User $user)
    {
        return $this->list($user);
    }
}
