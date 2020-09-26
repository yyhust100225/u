<?php

namespace App\Policies;

use Illuminate\Http\Request;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy extends CommonPolicy
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
}
