<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\TQStudentResource;
use App\Models\TQ;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Ixudra\Curl\Facades\Curl;

class TQController extends ProjectDepartmentController
{
    protected $admin_uin;
    protected $appkey;
    protected $token_url;
    protected $timestamp;

    public function __construct(Request $request)
    {
        $action = $request->route()->getActionMethod();
        $this->middleware('can:' . $action . ',' . TQ::class);

        // 初始化配置
        $this->admin_uin = '9773028';
        $this->appkey = 'kexin1202';
        $this->token_url = 'http://webservice.edu.tq.cn/webservice/getAccessToken';
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
     * @param string $contentType
     * @return mixed
     */
    protected function request($url, $data, $headers = [], $contentType = 'application/json')
    {
        if(!empty($headers)) {
            $headers = array(
                // 'Content-Type:application/x-www-form-urlencoded',
                'Accept:application/json,text/javascript, */*; q=0.01'
            );
        }

        $response = Curl::to($url)
            ->withData($data)
            ->withContentType("application/x-www-form-urlencoded")
            ->withHeaders($headers);

        return json_decode($response, true);
    }

    public function sync()
    {
        $data = [
            'admin_uin' => $this->admin_uin,
            'appkey' => $this->appkey,
            'ctime' => $this->timestamp,
            'sign' => $this->makeSign(),
        ];

        $token = $this->request($this->token_url, $data);
        dd($token);
    }

    protected function makeSign()
    {
        return strtoupper(md5($this->admin_uin . "$" . $this->appkey . "$" . $this->timestamp));
    }
}
