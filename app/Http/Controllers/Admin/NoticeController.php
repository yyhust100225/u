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
use Mockery\Matcher\Not;

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
            if (!empty($con['title']))
                $where['title'] = ['like', '%' . $con['title'] . '%'];
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
            if (!empty($con['title']))
                $where['title'] = ['like', '%' . $con['title'] . '%'];
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
     * 提交要讯状态
     * @param Request $request
     * @param Notice $notice
     * @return JsonResponse
     */
    public function commit(Request $request, Notice $notice)
    {
        $notice = $notice->newQuery()->findOrFail($request->input('id'));

        try {
            DB::transaction(function() use($notice){
                $notice->status = NOTICE_SUBMITTED;
                $notice->save();
            });
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            $this->returnFailedResponse(trans('request.failed'));
        }

        return $this->returnOperationResponse(true, $request);
    }

    /**
     * 撤回提交要讯
     * @param Request $request
     * @param Notice $notice
     * @return JsonResponse
     */
    public function withdraw(Request $request, Notice $notice)
    {
        $notice = $notice->newQuery()->findOrFail($request->input('id'));

        try {
            DB::transaction(function() use($notice){
                $notice->status = NOTICE_SAVED;
                $notice->save();
            });
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            $this->returnFailedResponse(trans('request.failed'));
        }

        return $this->returnOperationResponse(true, $request);
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
                $notice->content = strval($request->input('content'));
                $notice->status = intval($request->input('status'));
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
     * @param NoticeType $notice_type
     * @param Department $department
     * @param Role $role
     * @param User $user
     * @return Application|Factory|View
     */
    public function edit($id, Request $request,Notice $notice, NoticeType $notice_type, Department $department, Role $role, User $user)
    {
        $notice = $notice->newQuery()->with('file')->find($id);
        $notice->department_ids = $notice->departmentIds()->pluck('department_id')->toArray();
        $notice->role_ids = $notice->roleIds()->pluck('role_id')->toArray();
        $notice->user_ids = $notice->userIds()->pluck('user_id')->toArray();

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
     * 更新要讯信息
     * @param UpdateNotice $request
     * @param Notice $notice
     * @param MapNoticeToDepartments $mntd
     * @param MapNoticeToRoles $mntr
     * @param MapNoticeToUsers $mntu
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function update(UpdateNotice $request, Notice $notice, MapNoticeToDepartments $mntd, MapNoticeToRoles $mntr, MapNoticeToUsers $mntu)
    {
        try {
            $notice = $notice->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        try {
            DB::transaction(function() use($request, $notice, $mntd, $mntr, $mntu) {
                // 更新要讯主体
                $notice->title = strval($request->input('title'));
                $notice->notice_type_id = intval($request->input('notice_type_id'));
                $notice->start_time = $request->input('start_time');
                $notice->end_time = $request->input('end_time');
                $notice->file_id = strval($request->input('file_id'));
                $notice->user_id = Auth::user()->getAuthIdentifier();
                $notice->content = strval($request->input('content'));
                $notice->status = intval($request->input('status'));
                $notice->save();

                // 保存要讯抄送部门映射
                $mntd->deleteMaps($notice->id);
                if($request->filled('department_ids')) {
                    $department_ids = explode(',', $request->input('department_ids'));
                    foreach($department_ids as $department_id) {
                        $ntd_maps[] = ['department_id' => $department_id, 'notice_id' => $notice->id];
                    }
                    $mntd->insert($ntd_maps);
                }

                // 保存要讯抄送角色映射
                $mntr->deleteMaps($notice->id);
                if($request->filled('role_ids')) {
                    $role_ids = explode(',', $request->input('role_ids'));
                    foreach($role_ids as $role_id) {
                        $ntr_maps[] = ['role_id' => $role_id, 'notice_id' => $notice->id];
                    }
                    $mntr->insert($ntr_maps);
                }

                // 保存要讯抄送员工映射
                $mntu->deleteMaps($notice->id);
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
     * 删除要讯
     * @param Request $request
     * @param Notice $notice
     * @param MapNoticeToDepartments $mntd
     * @param MapNoticeToRoles $mntr
     * @param MapNoticeToUsers $mntu
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function delete(Request $request, Notice $notice, MapNoticeToDepartments $mntd, MapNoticeToRoles $mntr, MapNoticeToUsers $mntu)
    {
        try {
            $notice = $notice->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        try {
            DB::transaction(function() use($notice, $mntd, $mntr, $mntu) {
                $file = $notice->file;
                $mntd->deleteMaps($notice->id);
                $mntr->deleteMaps($notice->id);
                $mntu->deleteMaps($notice->id);
                $notice->delete();

                $disk = $file->disk;
                $path = $file->path;
                $file->delete();
                @Storage::disk($disk)->delete($path);
            });
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            $this->returnFailedResponse(trans('request.failed'));
        }

        return $this->returnOperationResponse(true, $request);
    }

    /**
     * 审核要讯列表页
     * @param Request $request
     * @return Application|Factory|View
     */
    public function reviews(Request $request)
    {
        return view('admin.notice.reviews');
    }

    /**
     * 待审核要讯列表
     * @param Request $request
     * @param Notice $notice
     * @return JsonResponse
     */
    public function reviewsData(Request $request, Notice $notice)
    {
        // 查询已提交状态公告
        $where = array('status' => ['in', [NOTICE_SUBMITTED, NOTICE_VIEWED]]);
        if ($request->has('action') && $request->input('action') == 'search') {
            parse_str($request->input('where'), $con);

            // 搜索条件
            if (!empty($con['title']))
                $where['title'] = ['like', '%' . $con['title'] . '%'];
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
     * 查看审核要讯
     * @param $id
     * @param Request $request
     * @param Notice $notice
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function show($id, Request $request, Notice $notice)
    {
        $notice = $notice->newQuery()->with(['departments', 'roles', 'users', 'file'])->findOrFail($id);

        // 变更要讯为已查看状态
        try {
            DB::transaction(function() use($notice) {
                $notice->status = NOTICE_VIEWED;
                $notice->save();
            });
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            abort(404, trans('message.errors.404'));
        }

        $notice->departments = implode(',', array_column($notice->departments->toArray(), 'name'));
        $notice->roles = implode(',', array_column($notice->roles->toArray(), 'name'));
        $notice->users = implode(',', array_column($notice->users->toArray(), 'username'));

        return view('admin.notice.show', [
            'notice' => $notice,
        ]);
    }

    /**
     * 要讯审核通过
     * @param Request $request
     * @param Notice $notice
     * @return JsonResponse
     */
    public function approve(Request $request, Notice $notice)
    {
        $notice = $notice->newQuery()->findOrFail($request->input('id'));

        try {
            DB::transaction(function() use($request, $notice){
                $notice->status = NOTICE_APPROVED;
                $notice->review_remark = strval($request->input('review_remark'));
                $notice->save();
            });
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            $this->returnFailedResponse(trans('request.failed'));
        }

        return $this->returnOperationResponse(true, $request);
    }

    /**
     * 要讯审核驳回
     * @param Request $request
     * @param Notice $notice
     * @return JsonResponse
     */
    public function reject(Request $request, Notice $notice)
    {
        $notice = $notice->newQuery()->findOrFail($request->input('id'));

        try {
            DB::transaction(function() use($request, $notice){
                $notice->status = NOTICE_REJECT;
                $notice->review_remark = strval($request->input('review_remark'));
                $notice->save();
            });
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            $this->returnFailedResponse(trans('request.failed'));
        }

        return $this->returnOperationResponse(true, $request);
    }
}
