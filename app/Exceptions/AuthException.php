<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class AuthException extends Exception
{
    protected $message;
    protected $status;

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->message = $message;
        $this->status = 401;
    }

    /**
     * 报告异常
     */
    public function report(Request $request)
    {
        Log::warning($request->ip() . ':' . $this->message);
    }

    /**
     * 异常返回Http响应
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render(Request $request)
    {
        return response()->json([
            'code' => REQUEST_FAILED,
            'message' => $this->message,
        ], $this->status);
    }
}
