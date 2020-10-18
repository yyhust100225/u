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
     * @param Request $request
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
        return $this->checkAuthorization($user, 'list');
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
        return $this->checkAuthorization($user, 'create');
    }

    /**
     * 存储数据权限
     * @param User $user
     * @return Response
     */
    public function store(User $user)
    {
        return $this->create($user);
    }

    /**
     * 编辑数据表单权限
     * @param User $user
     * @return Response
     */
    public function edit(User $user)
    {
        return $this->checkAuthorization($user, 'edit');
    }

    /**
     * 更新数据权限
     * @param User $user
     * @return Response
     */
    public function update(User $user)
    {
        return $this->edit($user);
    }

    /**
     * 删除数据权限
     * @return Response
     */
    public function delete(User $user)
    {
        return $this->checkAuthorization($user, 'delete');
    }

    /**
     * 验证指定用户是否有当前操作权限
     * @param User $user
     * @param $action
     * @return Response
     */
    protected function checkAuthorization(User $user, $action)
    {
        return $user->hasPrivilege($user, $this->controller_name, $action) ? Response::allow() : Response::deny(trans('auth.no authority'));
    }
}
