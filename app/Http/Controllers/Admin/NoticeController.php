<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DataNotExistsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNotice;
use App\Http\Requests\UpdateNotice;
use App\Http\Resources\NoticeResource;
use App\Models\Department;
use App\Models\Notice;
use App\Models\NoticeType;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
     * 存储新要讯
     * @param StoreNotice $request
     * @param Notice $notice
     * @return JsonResponse
     */
    public function store(StoreNotice $request, Notice $notice)
    {
        $notice->name = $request->input('name');

        return $this->returnOperationResponse($notice->save(), $request);
    }

    /**
     * 编辑要讯
     * @param $id
     * @param Request $request
     * @param Notice $notice
     * @return Application|Factory|View
     */
    public function edit($id, Request $request, Notice $notice)
    {
        $notice = $notice->newQuery()->find($id);

        return view('admin.notice.edit', [
            'notice' => $notice,
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
