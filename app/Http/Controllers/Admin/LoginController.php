<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\AuthException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class LoginController extends CommonController
{
    /**
     * 登录表单页
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        // 权限检查
        if(Auth::check()) {
            return redirect()->route('home');
        }

        return view('admin.auth.login');
    }

    /**
     * 登录验证
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     * @throws AuthException
     */
    public function login(Request $request)
    {
        // 登录字段验证
        $this->validateLogin($request);

        $credentials = $request->only($this->username(), 'password');
        $remember = (boolean)$request->input('remember', false);

        // 执行登录请求
        if(Auth::attempt($credentials, $remember)) {
            // 登录成功
            $context = [
                'id' => Auth::user()->getAuthIdentifier(),
                'username' => $request->input('username'),
                'ip' => $request->ip(),
            ];
            Log::info(trans('auth.success'), $context);
            return $this->authenticated($request, Auth::user());
        }
        else {
            // 登录失败, 返回Http响应
            return $this->sendFailedLoginResponse($request);
        }
    }

    /**
     * 退出登录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        return $this->loggedOut($request);
    }

    /**
     * 退出登录返回Http响应
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loggedOut(Request $request)
    {
        return response()->json([
            'code' => REQUEST_SUCCESS,
            'message' => trans('auth.logout'),
        ], 200);
    }

    /**
     * 登录表单验证
     * @param Request $request
     */
    public function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * 登录成功Http响应
     * @param Request $request
     * @param $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticated(Request $request, $user)
    {
        return response()->json([
            'code' => REQUEST_SUCCESS,
            'message' => trans('auth.success'),
        ], 200);
    }

    /**
     * 登录失败返回认证异常
     * @param Request $request
     * @throws AuthException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw new AuthException(trans('auth.failed'));
    }

    /**
     * 定义用户名字段
     * @return string
     */
    public function username()
    {
        return 'username';
    }
}
