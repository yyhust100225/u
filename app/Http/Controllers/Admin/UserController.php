<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DataNotExistsException;
use App\Http\Requests\ResetPassword;
use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends CommonController
{
    public function __construct(Request $request)
    {
        $action = $request->route()->getActionMethod();
        $this->middleware('can:' . $action . ',' . User::class);
        parent::__construct($request);
    }

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
        $where = array();
        if($request->has('action') && $request->input('action') == 'search'){
            parse_str($request->input('where'), $con);

            // 搜索条件
            if(!empty($con['username']))
                $where['username'] = ['like', '%'.$con['username'].'%'];
        }

        $list = $user->select($request->input('page'), $request->input('limit'), $where, 'role');

        return response()->json([
            'code' => RESPONSE_SUCCESS,
            'msg' => trans('request.success'),
            'count' => $list['count'],
            'data' => $list['data'],
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

    /**
     * 存储新用户
     * @param StoreUser $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUser $request, User $user)
    {
        $user->username = $request->input('username');
        $user->password = Hash::make($request->input('password'));
        $user->email = $request->input('email');
        $user->role_id = $request->input('role_id');
        $user->remark = $request->input('remark');

        return $this->returnOperationResponse($user->save(), $request);
    }

    /**
     * 编辑用户信息
     * @param $id
     * @param Request $request
     * @param User $user
     * @param Role $role
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, Request $request, User $user, Role $role)
    {
        $user = $user->newQuery();
        $user = $user->find($id);
        $roles = $role->roles();
        return view('admin.user.edit', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    /**
     * 更新用户信息
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     * @throws DataNotExistsException
     */
    public function update(UpdateUser $request, User $user)
    {
        try {
            $user = $user->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->role_id = $request->input('role_id');
        $user->remark = $request->input('remark');

        return $this->returnOperationResponse($user->save(), $request);
    }

    /**
     * 删除用户
     * @param Request $request
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     * @throws DataNotExistsException
     */
    public function delete(Request $request, User $user)
    {
        try {
            $user = $user->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        // 删除正在登录账户
        if(Auth::user()->getAuthIdentifier() == $user->id) {
            return response()->json([
                'success' => false,
                'code' => REQUEST_FAILED,
                'message' => trans('request.delete logged in account'),
            ], 403);
        }

        return $this->returnOperationResponse($user->delete(), $request);
    }

    /**
     * 重置用户密码页
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function password(Request $request)
    {
        return view('admin.user.password');
    }

    /**
     * 重置密码
     * @param ResetPassword $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(ResetPassword $request, User $user)
    {
        $user = $request->user();
        $user->password = Hash::make($request->input('n_password'));
        return $this->returnOperationResponse($user->save(), $request);
    }
}
