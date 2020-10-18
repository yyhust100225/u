<?php

namespace App\Policies;

use Illuminate\Http\Request;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookSalePolicy extends CommonPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     * @param Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }
}
