<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;

class MaterielPolicy extends CommonPolicy
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

    /**
     * 补充物料数量权限
     * @param User $user
     * @return \Illuminate\Auth\Access\Response
     */
    public function increase(User $user)
    {
        return $this->checkAuthorization($user, 'increase');
    }

    public function supplement(User $user)
    {
        return $this->increase($user);
    }

    /**
     * 消耗物料数量权限
     * @param User $user
     * @return \Illuminate\Auth\Access\Response
     */
    public function decrease(User $user)
    {
        return $this->checkAuthorization($user, 'decrease');
    }

    public function consume(User $user)
    {
        return $this->decrease($user);
    }
}
