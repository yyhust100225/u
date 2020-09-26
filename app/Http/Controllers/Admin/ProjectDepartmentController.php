<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectDepartmentController extends CommonController
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }
}
