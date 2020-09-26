<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends CommonController
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    /**
     * 根目录跳转登录页
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        return redirect()->route('login.form');
    }

    /**
     * 后台主页
     * @param Request $request
     */
    public function home(Request $request)
    {
        return view('admin.home.index');
    }

    public function main(Request $request)
    {
        dd(url()->previous());
        // return view('admin.home.main');
    }
}
