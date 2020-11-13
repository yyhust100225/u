<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;

class TQPolicy extends CommonPolicy
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

    // 同步学员信息权限
    public function sync(User $user)
    {
        return $this->list($user);
    }
}
