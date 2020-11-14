<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DataNotExistsException;
use App\Http\Resources\TQStudentResource;
use App\Models\Department;
use App\Models\TQ;
use App\Facades\Api;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class TQController extends ProjectDepartmentController
{
    // 校区TQ总账号
    protected $admin_uin;
    // TQ API秘钥
    protected $appkey;
    // 获取token地址
    protected $token_url;
    // 请求数据地址
    protected $visitor_url;
    // 当前时间戳
    protected $timestamp;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware('can:' . $this->request_action_name . ',' . TQ::class);
        // 初始化配置
        $this->admin_uin = env('TQ_ADMIN_UIN');
        $this->appkey = env('TQ_APPKEY');
        $this->token_url = env('TQ_TOKEN_URL');
        $this->visitor_url = env('TQ_VISITOR_URL');
        $this->timestamp = Carbon::now()->getTimestamp();
    }

    /**
     * TQ学员列表页
     * @return Application|Factory|View
     */
    public function list()
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
        // 制作搜索条件
        $where = $this->makeSearchConditions($request->input('where'));
        // 查询数据
        $tq_students = $tq->selectData($request->input('page'), $request->input('limit'), $where);
        // 返回表格数据响应
        return $this->returnTableData($tq_students, TQStudentResource::class);
    }

    /**
     * 同步TQ学员信息
     * @param TQ $tq
     * @return JsonResponse
     */
    public function sync(TQ $tq)
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
            'pageSize' => 1000,
            'col101' => TQ_SYNC_ALLOWED,
            'uin' => $TQ_no,
        );
        $response = Api::post($request_url, $data);

        if($response['errorCode'] == 0) {
            return $this->insertVisitors($response['data']['list'], $TQ_no, $tq);
        } else {
            Log::error($response['message'], $response);
            return $this->returnFailedResponse(trans('request.failed'));
        }
    }

    /**
     * 编辑TQ学员信息
     * @param Request $request
     * @param TQ $tq
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Request $request, TQ $tq, Department $department)
    {
        $departments = $department->all();
        $tq_student = $tq->newQuery()->find($request->input('id'));

        return view('admin.tq_student.edit', [
            'tq_student' => $tq_student,
            'departments' => $departments,
        ]);
    }

    /**
     * 更新TQ学生资源
     * @param Request $request
     * @param TQ $tq
     * @return bool|JsonResponse
     * @throws DataNotExistsException
     */
    protected function update(Request $request, TQ $tq)
    {
        try {
            $tq_student = $tq->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $tq_student->name = strval($request->input('name'));

        return $this->returnOperationResponse($tq_student->save());
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

        return Api::post($this->token_url, $data);
    }

    /**
     * 同步学员信息至本地库
     * @param $visitors
     * @param $uin
     * @param TQ $tq
     * @return JsonResponse
     */
    protected function insertVisitors($visitors, $uin, TQ $tq)
    {
        $resources = [];
        foreach($visitors as $visitor)
        {
            // 当前学生信息不从属于本账号
            if($visitor['uin'] != $uin)
                continue;

            // 当前学员信息已存在, 跳过
            if($tq_student = $tq->newQuery()->where('tq_id', $visitor['id'])->first())
                continue;

            // 拼接学生资源数组
            {
                $insert['tq_id'] = strval($visitor['id']);
                $insert['admin_uin'] = strval($visitor['admin_uin']);
                $insert['uin'] = strval($visitor['uin']);
                $insert['creator_uin'] = strval($visitor['create_uin']);
                $insert['address'] = strval($visitor['client_adress']);
                $insert['mobile'] = strval($visitor['client_mobile']);
                $insert['name'] = strval($visitor['client_name']);
                $insert['qq'] = strval($visitor['client_qq']);
                $insert['level'] = intval($visitor['client_range']);
                $insert['remark'] = strval($visitor['client_resume']);
                $insert['gender'] = intval($visitor['client_sex']);
                $insert['telephone'] = strval($visitor['client_telephone']);
                $insert['wechat'] = strval($visitor['client_weixin']);
                $insert['insert_time'] = Carbon::createFromTimestamp($visitor['insert_time'])->toDateTimeString();
                $insert['last_contact_time'] = ($visitor['last_contact_time'] == null ? null : Carbon::createFromTimestamp($visitor['last_contact_time'])->toDateTimeString());
                $insert['phone_calls'] = intval($visitor['phone_number']);
                $insert['update_time'] = ($visitor['update_time'] == null ? null : Carbon::createFromTimestamp($visitor['update_time'])->toDateTimeString());
                // $insert['department_id'] = intval($visitor['view_department_id']);
                // $insert['party_number'] = strval($visitor['china']);
                // $insert['attestation'] = strval($visitor['attestation']);
                $insert['school'] = strval($visitor['col2']);
                $insert['major'] = strval($visitor['col3']);
                $insert['company'] = strval($visitor['col4']);
                $insert['job'] = strval($visitor['col5']);
                $insert['ID_card_no'] = strval($visitor['col6']);
                $insert['examination'] = strval($visitor['col10']);
                $insert['class_type'] = strval($visitor['col11']);
                $insert['political'] = strval($visitor['col12']);
                $insert['english_level'] = strval($visitor['col13']);
                $insert['current_address'] = strval($visitor['col14']);
                $insert['resource_owner'] = strval($visitor['col16']);
                $insert['resource_activity'] = strval($visitor['col17']);
                $insert['visit_back_date'] = ($visitor['col62'] == null ? null : Carbon::createFromTimestamp($visitor['col62'])->toDateString());
                $insert['call_back_date'] = ($visitor['col64'] == null ? null : Carbon::createFromTimestamp($visitor['col64'])->toDateString());
                $insert['way_to_visit'] = intval($visitor['col71']);
                $insert['exam_type'] = intval($visitor['col72']);
                $insert['belong_to'] = intval($visitor['col74']);
                $insert['education'] = intval($visitor['col76']);
                $insert['identity'] = intval($visitor['col77']);
                $insert['common_tested'] = intval($visitor['col78']);
                $insert['trained'] = intval($visitor['col79']);
                $insert['resource_method'] = intval($visitor['col99']);
                $insert['belongs_to_department'] = intval($visitor['col100']);
                $insert['tq_synchronization'] = intval($visitor['col101']);
                $insert['user_id'] = $this->user()->getAuthIdentifier();
            }
            array_push($resources, $insert);
        }

        try {
            $tq->newQuery()->insert($resources);
        } catch(Exception $exception) {
            Log::error($exception->getMessage());
            return $this->returnFailedResponse(trans('message.db.tq sync error'), 500);
        }

        return $this->returnOperationResponse(true);
    }

    // 制作请求签名
    protected function makeSign()
    {
        return strtoupper(md5($this->admin_uin . "$" . $this->appkey . "$" . $this->timestamp));
    }
}
