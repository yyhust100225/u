<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreUser;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends CommonController
{

    /**
     * 账户列表页
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(Request $request, User $user)
    {
        return view('admin.user.users');
    }

    /**
     * 账户列表数据
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request, User $user)
    {
        $users = $user->data($request->input('page'), $request->input('limit'));
        $count = $user->num();

        foreach($users as $user) {
            $user->role;
        }

        return response()->json([
            'code' => RESPONSE_SUCCESS,
            'msg' => trans('request.success'),
            'count' => $count,
            'data' => $users,
        ], 200);
    }

    /**
     * 创建新用户
     * @param Request $request
     * @param Role $role
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request, Role $role)
    {
        $roles = $role->roles();

        return view('admin.user.create', [
            'roles' => $roles,
        ]);
    }

    public function store(StoreUser $request, User $user)
    {
        $user->username = $request->input('username');
        $user->password = Hash::make($request->input('password'));
        $user->email = $request->input('email');
        $user->role_id = $request->input('role_id');
        $user->remark = $request->input('remark');

        return $this->returnOperationResponse($user->save(), $request);
    }
}
