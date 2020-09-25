<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DataNotExistsException;
use App\Http\Requests\StoreDepartment;
use App\Http\Requests\UpdateDepartment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Http\Resources\DepartmentResource;
use Illuminate\Support\Facades\Redis;

class DepartmentController extends CommonController
{
    public function __construct(Request $request)
    {
        $action = $request->route()->getActionMethod();
        $this->middleware('can:' . $action . ',' . Department::class);
        parent::__construct();
    }

    /**
     * 行政部门列表页
     * @param Request $request
     * @param Department $department
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(Request $request, Department $department)
    {
        return view('admin.department.departments');
    }

    /**
     * 行政部门列表数据
     * @param Request $request
     * @param Department $department
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request, Department $department)
    {
        $where = array();
        if($request->has('action') && $request->input('action') == 'search'){
            parse_str($request->input('where'), $con);

            // 搜索条件
            if(!empty($con['name']))
                $where['name'] = ['like', '%'.$con['name'].'%'];
        }

        $departments = $department->select($request->input('page'), $request->input('limit'), $where);

        return response()->json([
            'code' => RESPONSE_SUCCESS,
            'msg' => trans('request.success'),
            'count' => $departments['count'],
            'data' => DepartmentResource::collection($departments['data']),
        ], 200);
    }

    /**
     * 创建新行政部门
     * @param Request $request
     * @param Department $department
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request, Department $department)
    {
        $parent_departments = $department->all();
        return view('admin.department.create', [
            'parent_departments' => $parent_departments,
        ]);
    }

    /**
     * 存储新行政部门
     * @param StoreDepartment $request
     * @param Department $department
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreDepartment $request, Department $department)
    {
        $department->name = $request->input('name');
        $department->p_id = $request->input('p_id');
        $department->remark = $request->input('remark');

        return $this->returnOperationResponse($department->save(), $request);
    }

    /**
     * 编辑行政部门
     * @param $id
     * @param Request $request
     * @param Department $department
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, Request $request, Department $department)
    {
        $parent_departments = $department->all();
        $department = $department->newQuery()->find($id);

        return view('admin.department.edit', [
            'parent_departments' => $parent_departments,
            'department' => $department,
        ]);
    }

    /**
     * 更新行政部门
     * @param UpdateDepartment $request
     * @param Department $department
     * @return \Illuminate\Http\JsonResponse
     * @throws DataNotExistsException
     */
    public function update(UpdateDepartment $request, Department $department)
    {
        try {
            $department = $department->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $department->name = $request->input('name');
        $department->p_id = $request->input('p_id');
        $department->remark = $request->input('remark');

        return $this->returnOperationResponse($department->save(), $request);
    }

    /**
     * 删除行政部门
     * @param Request $request
     * @param Department $department
     * @return \Illuminate\Http\JsonResponse
     * @throws DataNotExistsException
     */
    public function delete(Request $request, Department $department)
    {
        try {
            $department = $department->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }
        return $this->returnOperationResponse($department->delete(), $request);
    }
}
