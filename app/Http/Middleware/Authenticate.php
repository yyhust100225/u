<?php

namespace App\Http\Middleware;

use App\Exceptions\AuthorityExpiredException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login.form');
        }
    }

    protected function unauthenticated($request, array $guards)
    {
        throw new AuthorityExpiredException(trans('request.authority expired'));
    }
}
