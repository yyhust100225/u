<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 后台主页
     * @param Request $request
     */
    public function index(Request $request)
    {
        return view('admin.home.index');
    }
}
