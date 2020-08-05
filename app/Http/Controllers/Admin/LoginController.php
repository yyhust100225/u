<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    // 登录表单页
    public function login()
    {
        return view('admin.auth.login');
    }

    // 登录验证
    public function loginValidated(Request $request)
    {
        $credentials = $request->all();

        return response()->json(['message' => 'socket success'], 200);
    }
}
