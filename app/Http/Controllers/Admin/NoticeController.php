<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\File;
use App\Exceptions\DataNotExistsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNotice;
use App\Http\Requests\UpdateNotice;
use App\Http\Resources\NoticeResource;
use App\Models\Department;
use App\Models\Maps\MapNoticeToDepartments;
use App\Models\Maps\MapNoticeToRoles;
use App\Models\Maps\MapNoticeToUsers;
use App\Models\Notice;
use App\Models\NoticeType;
use App\Models\Role;
use App\Models\User;
use App\Tools\Upload;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class NoticeController extends CommonController
{
    public function __construct(Request $request)
    {
        $action = $request->route()->getActionMethod();
        $this->middleware('can:' . $action . ',' . Notice::class);
        parent::__construct($request);
    }

    /**
     * 要讯列表页
     * @param Request $request
     * @param Notice $notice
     * @return Application|Factory|View
     */
    public function list(Request $request, Notice $notice)
    {
        return view('admin.notice.list');
    }

    /**
     * 要讯列表数据
     * @param Request $request
     * @param Notice $notice
     * @return JsonResponse
     */
    public function data(Request $request, Notice $notice)
    {
        $where = array();
        if ($request->has('action') && $request->input('action') == 'search') {
            parse_str($request->input('where'), $con);

            // 搜索条件
            if (!empty($con['name']))
                $where['name'] = ['like', '%' . $con['name'] . '%'];
        }

        $notices = $notice->selectData($request->input('page'), $request->input('limit'), $where);

        return response()->json([
            'code' => RESPONSE_SUCCESS,
            'msg' => trans('request.success'),
            'count' => $notices['count'],
            'data' => NoticeResource::collection($notices['data']),
        ], 200);
    }

    /**
     * 发布要讯列表页
     * @param Request $request
     * @return Application|Factory|View
     */
    public function publish(Request $request)
    {
        return view('admin.notice.publish');
    }

    /**
     * 已发布要讯列表数据
     * @param Request $request
     * @param Notice $notice
     * @return JsonResponse
     */
    public function publishData(Request $request, Notice $notice)
    {
        // 查询发布人为当前账号的要讯
        $where = array('user_id' => $request->user()->getAuthIdentifier());
        if ($request->has('action') && $request->input('action') == 'search') {
            parse_str($request->input('where'), $con);

            // 搜索条件
            if (!empty($con['name']))
                $where['name'] = ['like', '%' . $con['name'] . '%'];
        }

        $notices = $notice->selectData($request->input('page'), $request->input('limit'), $where);

        return response()->json([
            'code' => RESPONSE_SUCCESS,
            'msg' => trans('request.success'),
            'count' => $notices['count'],
            'data' => NoticeResource::collection($notices['data']),
        ], 200);
    }

    /**
     * 创建新要讯
     * @param Request $request
     * @return Application|Factory|View
     */
    public function create(Request $request, NoticeType $notice_type, Department $department, Role $role, User $user)
    {
        $notice_types = $notice_type->all();
        $departments = $department->all();
        $roles = $role->all();
        $users = $user->all();

        return view('admin.notice.create', [
            'notice_types' => $notice_types,
            'departments' => $departments,
            'roles' => $roles,
            'users' => $users,
        ]);
    }

    /**
     * 存储要讯
     * @param StoreNotice $request
     * @param Notice $notice
     * @param MapNoticeToDepartments $mntd
     * @param MapNoticeToRoles $mntr
     * @param MapNoticeToUsers $mntu
     * @return JsonResponse
     */
    public function store(StoreNotice $request, Notice $notice, MapNoticeToDepartments $mntd, MapNoticeToRoles $mntr, MapNoticeToUsers $mntu)
    {
        try {
            DB::transaction(function() use($request, $notice, $mntd, $mntr, $mntu) {
                // 存储要讯主体
                $notice->title = strval($request->input('title'));
                $notice->notice_type_id = intval($request->input('notice_type_id'));
                $notice->start_time = $request->input('start_time');
                $notice->end_time = $request->input('end_time');
                $notice->file_id = strval($request->input('file_id'));
                $notice->user_id = Auth::user()->getAuthIdentifier();
                $notice->content = htmlspecialchars(strval($request->input('content')));
                $notice->status = NOTICE_SUBMITTED;
                $notice->save();

                // 保存要讯抄送部门映射
                if($request->filled('department_ids')) {
                    $department_ids = explode(',', $request->input('department_ids'));
                    foreach($department_ids as $department_id) {
                        $ntd_maps[] = ['department_id' => $department_id, 'notice_id' => $notice->id];
                    }
                    $mntd->insert($ntd_maps);
                }

                // 保存要讯抄送角色映射
                if($request->filled('role_ids')) {
                    $role_ids = explode(',', $request->input('role_ids'));
                    foreach($role_ids as $role_id) {
                        $ntr_maps[] = ['role_id' => $role_id, 'notice_id' => $notice->id];
                    }
                    $mntr->insert($ntr_maps);
                }

                // 保存要讯抄送员工映射
                if($request->filled('user_ids')) {
                    $user_ids = explode(',', $request->input('user_ids'));
                    foreach($user_ids as $user_id) {
                        $ntu_maps[] = ['user_id' => $user_id, 'notice_id' => $notice->id];
                    }
                    $mntu->insert($ntu_maps);
                }
            });
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            $this->returnFailedResponse(trans('request.failed'));
        }

        return $this->returnOperationResponse(true, $request);
    }

    /**
     * 编辑要讯
     * @param $id
     * @param Request $request
     * @param Notice $notice
     * @return Application|Factory|View
     */
    public function edit($id, Request $request,Notice $notice, NoticeType $notice_type, Department $department, Role $role, User $user)
    {
        $notice = $notice->newQuery()->find($id);
        $notice->department_ids = $notice->departmentIds()->pluck('department_id')->toArray();

        $notice_types = $notice_type->all();
        $departments = $department->all();
        $roles = $role->all();
        $users = $user->all();

        return view('admin.notice.edit', [
            'notice' => $notice,
            'notice_types' => $notice_types,
            'departments' => $departments,
            'roles' => $roles,
            'users' => $users,
        ]);
    }

    /**
     * 更新要讯
     * @param UpdateNotice $request
     * @param Notice $notice
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function update(UpdateNotice $request, Notice $notice)
    {
        try {
            $notice = $notice->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $notice->name = strval($request->input('name'));

        return $this->returnOperationResponse($notice->save(), $request);
    }

    /**
     * 删除要讯
     * @param Request $request
     * @param Notice $notice
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function delete(Request $request, Notice $notice)
    {
        try {
            $notice = $notice->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }
        return $this->returnOperationResponse($notice->delete(), $request);
    }
}
