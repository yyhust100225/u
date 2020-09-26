<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    /**
     * 后台控制器基类构造方法
     * CommonController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {

    }

    /**
     * 返回ajax响应结果
     * @param $operation
     * @param Request $request
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    protected function returnOperationResponse($operation, Request $request, $status = 200)
    {
        if($operation) {
            $response = [
                'success' => true,
                'code' => REQUEST_SUCCESS,
                'message' => trans('request.success'),
            ];
        } else {
            $response = [
                'success' => false,
                'code' => REQUEST_FAILED,
                'message' => trans('request.failed'),
            ];
        }
        return response()->json($response, $status);
    }
}
