<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;

class StudentPolicy extends CommonPolicy
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

    // 搜索学生信息权限
    public function search(User $user)
    {
        return $this->list($user);
    }

    public function searched(User $user)
    {
        return $this->search($user);
    }

    // 创建学生信息权限
    public function create(User $user)
    {
        return $this->list($user);
    }

    public function classCourses(User $user)
    {
        return $this->create($user);
    }

    public function classCoursesData(User $user)
    {
        return $this->classCourses($user);
    }

    // 编辑学生信息权限
    public function edit(User $user)
    {
        return $this->list($user);
    }

    // 删除学生信息权限
    public function delete(User $user)
    {
        return $this->list($user);
    }
}
