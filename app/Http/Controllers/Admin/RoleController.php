<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DataNotExistsException;
use App\Models\Role;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class RoleController extends CommonController
{
    /**
     * 角色列表页
     * @param Request $request
     * @param Role $role
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(Request $request, Role $role)
    {
        return view('admin.role.roles');
    }

    /**
     * 角色列表数据
     * @param Request $request
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request, Role $role)
    {
        $roles = $role->data($request->input('page'), $request->input('limit'));
        $count = $role->num();

        return response()->json([
            'code' => RESPONSE_SUCCESS,
            'msg' => trans('request.success'),
            'count' => $count,
            'data' => $roles,
        ], 200);
    }

    /**
     * 创建新角色
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('admin.role.create');
    }

    /**
     * 存储新角色
     * @param Request $request
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Role $role)
    {
        $role->name = $request->input('name');
        $role->status = $request->has('status') ? 1 : 0;
        $role->remark = $request->input('remark');

        return $this->returnOperationResponse($role->save(), $request);
    }

    /**
     * 编辑新角色
     * @param $id
     * @param Request $request
     * @param Role $role
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, Request $request, Role $role)
    {
        $role = $role->find($id);
        return view('admin.role.edit', [
            'role' => $role,
        ]);
    }

    /**
     * 更新新角色
     * @param Request $request
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     * @throws DataNotExistsException
     */
    public function update(Request $request, Role $role)
    {
        try {
            $role = $role->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $role->name = $request->input('name');
        $role->status = $request->has('status') ? 1 : 0;
        $role->remark = $request->input('remark');

        return $this->returnOperationResponse($role->save(), $request);
    }

    public function delete(Request $request, Role $role)
    {
        try {
            $role = $role->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        return $this->returnOperationResponse($role->delete(), $request);
    }
}
