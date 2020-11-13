<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\TQStudentResource;
use App\Models\TQ;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Ixudra\Curl\Facades\Curl;

class TQController extends ProjectDepartmentController
{
    protected $admin_uin;
    protected $appkey;
    protected $token_url;
    protected $visitor_url;
    protected $timestamp;

    public function __construct(Request $request)
    {
        $action = $request->route()->getActionMethod();
        $this->middleware('can:' . $action . ',' . TQ::class);

        // 初始化配置
        $this->admin_uin = '9773028';
        $this->appkey = 'kexin1202';
        $this->token_url = 'http://webservice.edu.tq.cn/webservice/getAccessToken';
        $this->visitor_url = 'http://webservice.edu.tq.cn/webservice/visitorInfo/list';
        $this->timestamp = Carbon::now()->getTimestamp();
        parent::__construct($request);
    }

    /**
     * TQ学员列表页
     * @param Request $request
     * @return Application|Factory|View
     */
    public function list(Request $request)
    {
        return view('admin.tq_student.list');
    }

    /**
     * TQ学员列表数据
     * @param Request $request
     * @param TQ $tq
     * @return JsonResponse
     */
    public function data(Request $request, TQ $tq)
    {
        $where = array();
        if($request->has('action') && $request->input('action') == 'search'){
            parse_str($request->input('where'), $con);

            // 搜索条件
            if(!empty($con['name']))
                $where['name'] = ['like', '%'.$con['name'].'%'];
        }

        $tqs = $tq->selectData($request->input('page'), $request->input('limit'), $where);

        return response()->json([
            'code' => RESPONSE_SUCCESS,
            'msg' => trans('request.success'),
            'count' => $tqs['count'],
            'data' => TQStudentResource::collection($tqs['data']),
        ], 200);
    }

    /**
     * 模拟请求
     * @param $url
     * @param $data
     * @param array $headers
     * @return mixed
     */
    protected function request($url, $data, $headers = [])
    {
        if(!empty($headers)) {
            $headers = array(
                'Content-Type:application/x-www-form-urlencoded',
                'Accept:application/json,text/javascript, */*; q=0.01'
            );
        }

        $response = Curl::to($url)
            ->withData($data)
            ->withHeaders($headers)
            ->post();

        return json_decode($response, true);
    }

    /**
     * 获取TOKEN
     * @return mixed
     */
    protected function token()
    {
        $data = [
            'admin_uin' => $this->admin_uin,
            'appkey' => $this->appkey,
            'ctime' => $this->timestamp,
            'sign' => $this->makeSign(),
        ];

        return $this->request($this->token_url, $data);
    }

    /**
     * 同步TQ学员信息
     * @return false|JsonResponse|string
     */
    public function sync()
    {
        $TQ_no = $this->user()->archive->TQ_no;

        // 该账号无效TQ号
        if(!$TQ_no) {
            return $this->returnFailedResponse(trans('request.TQ no invalid'),200);
        }

        $token = $this->token();
        // 获取token失败
        if(isset($token['errorCode']) && $token['errorCode'] == -1) {
            Log::error($token['exceptionMessage']);
            return $this->returnFailedResponse(trans('request.failed'),500);
        }

        // 组成请求地址
        $params = array(
            'access_token' => $token['access_token'],
            'admin_uin' => $this->admin_uin,
        );
        $request_url = $this->visitor_url . '?' . http_build_query($params);

        // 组成请求参数
        $data = array(
            'order_name' => 'id',
            'order_rule' => 'DESC',
            'pageSize' => 100,
            'col101' => TQ_SYNC_ALLOWED,
            'uin' => $TQ_no,
        );
        $response = $this->request($request_url, $data);

        return json_encode($response);
    }

    // 制作请求签名
    protected function makeSign()
    {
        return strtoupper(md5($this->admin_uin . "$" . $this->appkey . "$" . $this->timestamp));
    }
}
