<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;

class ClassTypePolicy extends CommonPolicy
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

    // 创建班型权限
    public function create(User $user)
    {
        return $this->list($user);
    }

    // 编辑班型权限
    public function edit(User $user)
    {
        return $this->list($user);
    }

    // 删除班型权限
    public function delete(User $user)
    {
        return $this->list($user);
    }

    // 查询优惠列表权限
    public function discounts(User $user)
    {
        return $this->list($user);
    }

    public function discountsData(User $user)
    {
        return $this->discounts($user);
    }

    // 创建班型优惠权限
    public function discountCreate(User $user)
    {
        return $this->list($user);
    }

    public function discountStore(User $user)
    {
        return $this->discountCreate($user);
    }

    // 编辑班型优惠权限
    public function discountEdit(User $user)
    {
        return $this->list($user);
    }

    public function discountUpdate(User $user)
    {
        return $this->discountEdit($user);
    }

    // 删除班型优惠权限
    public function discountDelete(User $user)
    {
        return $this->list($user);
    }
}
