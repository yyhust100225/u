<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DataNotExistsException;
use App\Models\Permission;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PermissionController extends CommonController
{
    public function __construct(Request $request)
    {
        $action = $request->route()->getActionMethod();
        $this->middleware('can:' . $action . ',' . Permission::class);
        parent::__construct($request);
    }

    /**
     * 权限列表页
     * @param Request $request
     * @param Permission $permission
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(Request $request, Permission $permission)
    {
        return view('admin.permission.permissions');
    }

    /**
     * 权限列表数据
     * @param Request $request
     * @param Permission $permission
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request, Permission $permission)
    {
        $where = array();
        if($request->has('action') && $request->input('action') == 'search'){
            parse_str($request->input('where'), $con);

            // 搜索条件
            if(!empty($con['name']))
                $where['name'] = ['like', '%'.$con['name'].'%'];
        }

        $permissions = $permission->select($request->input('page'), $request->input('limit'), $where);

        return response()->json([
            'code' => RESPONSE_SUCCESS,
            'msg' => trans('request.success'),
            'count' => $permissions['count'],
            'data' => $permissions['data'],
        ], 200);
    }

    /**
     * 创建新权限
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('admin.permission.create');
    }

    /**
     * 存储新权限
     * @param Request $request
     * @param Permission $permission
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Permission $permission)
    {
        $permission->name = $request->input('name');
        $permission->controller = $request->input('controller');
        $permission->action = $request->input('action');
        $permission->level = $request->input('level');
        $permission->remark = strval($request->input('remark'));

        return $this->returnOperationResponse($permission->save(), $request);
    }

    /**
     * 编辑新权限
     * @param $id
     * @param Request $request
     * @param Permission $permission
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, Request $request, Permission $permission)
    {
        $permission = $permission->newQuery()->find($id);

        return view('admin.permission.edit', [
            'permission' => $permission,
        ]);
    }

    /**
     * 更新新权限
     * @param Request $request
     * @param Permission $permission
     * @return \Illuminate\Http\JsonResponse
     * @throws DataNotExistsException
     */
    public function update(Request $request, Permission $permission)
    {
        try {
            $permission = $permission->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $permission->name = $request->input('name');
        $permission->controller = $request->input('controller');
        $permission->action = $request->input('action');
        $permission->level = $request->input('level');
        $permission->remark = strval($request->input('remark'));

        return $this->returnOperationResponse($permission->save(), $request);
    }

    /**
     * 删除新权限
     * @param Request $request
     * @param Permission $permission
     * @return \Illuminate\Http\JsonResponse
     * @throws DataNotExistsException
     */
    public function delete(Request $request, Permission $permission)
    {
        try {
            $permission = $permission->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }
        return $this->returnOperationResponse($permission->delete(), $request);
    }
}
