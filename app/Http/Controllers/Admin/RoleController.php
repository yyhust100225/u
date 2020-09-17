<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DataNotExistsException;
use App\Models\Maps\MapRoleToPermissions;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends CommonController
{
    public function __construct(Request $request)
    {
        $action = $request->route()->getActionMethod();
        $this->middleware('can:' . $action . ',' . Role::class);
        parent::__construct();
    }

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
     * @param Permission $permission
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request, Permission $permission)
    {
        $permission_list = $permission->all();

        $permissions = [];
        foreach($permission_list as $var) {
            $permissions[$var['controller']][] = $var;
        }

        return view('admin.role.create', [
            'permissions' => array_values($permissions),
        ]);
    }

    /**
     * 存储新角色
     * @param Request $request
     * @param Role $role
     * @param MapRoleToPermissions $mrtp
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Role $role, MapRoleToPermissions $mrtp)
    {
        $role->name = $request->input('name');
        $role->status = $request->has('status') ? 1 : 0;
        $role->remark = $request->input('remark');

        $ret = true;
        DB::transaction(function() use($request, $role, $mrtp, &$ret){
            if(!$role->save()) $ret = false;
            if(!$mrtp->saveRoleToPermissions($role->id, $request->input('permission'))) $ret = false;
        });

        return $this->returnOperationResponse($ret, $request);
    }

    /**
     * 编辑新角色
     * @param $id
     * @param Request $request
     * @param Role $role
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, Request $request, Role $role, Permission $permission, MapRoleToPermissions $mrtp)
    {
        $role = $role->newQuery();
        $role = $role->find($id);
        $permission_list = $permission->all();

        // 角色权限
        $my_permissions = [];
        foreach($role->permissions as $my_permission) {
            $my_permissions[] = $my_permission->id;
        }

        // 全部权限
        $permissions = [];
        foreach($permission_list as $var) {
            $permissions[$var['controller']][] = $var;
        }

        return view('admin.role.edit', [
            'role' => $role,
            'permissions' => array_values($permissions),
            'my_permissions' => $my_permissions,
        ]);
    }

    /**
     * 更新新角色
     * @param Request $request
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     * @throws DataNotExistsException
     */
    public function update(Request $request, Role $role, MapRoleToPermissions $mrtp)
    {
        try {
            $role = $role->newQuery();
            $role = $role->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $role->name = $request->input('name');
        $role->status = $request->has('status') ? 1 : 0;
        $role->remark = $request->input('remark');

        $ret = true;
        DB::transaction(function() use($request, $role, $mrtp, &$ret){
            if(!$role->save()) $ret = false;
            if(!$mrtp->saveRoleToPermissions($role->id, $request->input('permission'))) $ret = false;
        });

        return $this->returnOperationResponse($role->save(), $request);
    }

    /**
     * 删除新角色
     * @param Request $request
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     * @throws DataNotExistsException
     */
    public function delete(Request $request, Role $role)
    {
        try {
            $role = $role->newQuery();
            $role = $role->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        return $this->returnOperationResponse($role->delete(), $request);
    }
}
