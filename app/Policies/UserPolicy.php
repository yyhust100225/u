<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;

class UserPolicy extends CommonPolicy
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
     * 修改账户密码权限
     * @param User $user
     * @return \Illuminate\Auth\Access\Response
     */
    public function password(User $user)
    {
        return $this->checkAuthorization($user, 'password');
    }

    /**
     * 重置密码权限
     * @param User $user
     * @return \Illuminate\Auth\Access\Response
     */
    public function reset(User $user)
    {
        return $this->password($user);
    }
}
