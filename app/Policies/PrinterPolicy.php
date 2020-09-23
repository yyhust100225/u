<?php

namespace App\Policies;

use Illuminate\Http\Request;
use Illuminate\Auth\Access\HandlesAuthorization;

class PrinterPolicy extends CommonPolicy
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
}
