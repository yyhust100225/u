<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;

class CommonPolicy
{
    use HandlesAuthorization;
    protected $controller_name;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $action_name = $request->route()->getActionName();
        $controller_name = explode('\\', explode('@', $action_name)[0]);
        end($controller_name);
        $this->controller_name = end($controller_name);
    }

    /**
     * 用户查看表数据权限
     * @param User $user
     * @return Response
     */
    public function list(User $user)
    {
        return $user->hasPrivilege($user, $this->controller_name, 'list') ? Response::allow() : Response::deny('没有查看角色数据的授权');
    }

    /**
     * 获取表数据权限(同步查看表数据权限)
     * @param User $user
     * @return Response
     */
    public function data(User $user)
    {
        return $this->list($user);
    }

    /**
     * 创建表数据权限
     * @param User $user
     * @return Response
     */
    public function create(User $user)
    {
        return $user->hasPrivilege($user, $this->controller_name, 'create') ? Response::allow() : Response::deny('没有创建数据授权');
    }

    public function store(User $user)
    {
        return $this->create($user);
    }

    public function edit(User $user)
    {
        return true;
    }

    public function update(User $user)
    {
        return $this->edit($user);
    }

    public function delete()
    {
        return true;
    }
}
