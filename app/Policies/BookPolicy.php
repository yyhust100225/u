<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;

class BookPolicy extends CommonPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    /**
     * 补充书籍数量权限
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
     * 消耗书籍数量权限
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
