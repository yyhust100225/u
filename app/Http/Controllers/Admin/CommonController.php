<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommonController extends Controller
{
    // 当前路由方法
    protected $request_action_name;

    /**
     * 后台控制器基类构造方法
     * CommonController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        DB::connection()->enableQueryLog();
        // 获取当前路由方法
        $this->request_action_name = $request->route()->getActionMethod();
    }

    /**
     * 返回ajax响应结果
     * @param $operation
     * @param null $request
     * @param int $status
     * @return JsonResponse
     */
    protected function returnOperationResponse($operation, $request = null, int $status = 200)
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

    /**
     * 返回ajax自定义错误响应
     * @param $message
     * @param int $status
     * @return JsonResponse
     */
    protected function returnFailedResponse($message, $status = 200)
    {
        $response = [
            'success' => false,
            'code' => REQUEST_FAILED,
            'message' => $message,
        ];
        return response()->json($response, $status);
    }

    /**
     * 返回表格数据格式
     * @param array $data
     * @param string $resource_class_name
     * @return JsonResponse
     */
    protected function returnTableData(array $data, string $resource_class_name)
    {
        return response()->json([
            'code' => RESPONSE_SUCCESS,
            'msg' => trans('request.success'),
            'count' => $data['count'],
            'data' => $resource_class_name::collection($data['data']),
        ], 200);
    }

    /**
     * 获取当前访问请求用户
     */
    protected function user()
    {
        return Auth::user();
    }

    /**
     * 获取表格搜索条件
     * @param $conditions
     * @param array $where
     * @return array|mixed
     */
    protected function makeSearchConditions($conditions, $where = [])
    {
        if(!empty($conditions)) {
            foreach ($conditions as $condition) {
                if (is_null($condition['value']) || $condition['value'] === '') continue;
                $field = explode('|', $condition['name']);
                switch ($field[0]) {
                    case 'like':
                        {
                            $where[$field[1]] = ['like', '%' . $condition['value'] . '%'];
                        }
                        break;
                    default:
                    {
                        $where[$field[0]] = $condition['value'];
                    }
                }
            }
        }
        return $where;
    }
}
