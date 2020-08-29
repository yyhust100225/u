<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;

class DataNotExistsException extends Exception
{
    protected $data;

    public function __construct($message = "", $code = 0, $data = [], Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->data = $data;
    }

    /**
     * 找不到数据时记录日志操作记录
     * @return void
     */
    public function report()
    {
        Log::warning(trans('message.log.an empty query occurred'));
    }

    /**
     * 找不到数据时返回报告响应
     * @return \Illuminate\Http\JsonResponse
     */
    public function render()
    {
        return response()->json([
            'success' => false,
            'code' => $this->getCode(),
            'message' => $this->getMessage(),
        ], 404);
    }
}
