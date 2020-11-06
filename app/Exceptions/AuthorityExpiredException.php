<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Throwable;

class AuthorityExpiredException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->message = $message;
        $this->code = $code !== 0 ? $code : 401;
    }

    public function render(Request $request)
    {
        // 登录过期异常
        if($request->expectsJson()) {
            return response()->json([
                'message' => $this->getMessage(),
            ], $this->getCode());
        } else {
            return redirect()->route('login.form');
        }
    }
}
