<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    // 公共基类构造方法
    public function __construct()
    {

    }

    /**
     * 返回请求成功JSON响应
     * @param array $data
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function returnSuccessJsonResponse($data = [], $status = 200)
    {
        return response()->json([
            'success' => true,
            'code' => REQUEST_SUCCESS,
            'message' => trans('request.success'),
            'data' => $data,
        ], $status);
    }

    /**
     * 返回请求失败JSON响应
     * @param string $message
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function returnFailedJsonResponse($message = '', $status = 200)
    {
        return response()->json([
            'success' => false,
            'code' => REQUEST_FAILED,
            'message' => $message ?? trans('request.failed'),
        ], $status);
    }
}
