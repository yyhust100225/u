<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DataNotExistsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployee;
use App\Http\Requests\UpdateEmployee;
use App\Http\Resources\EmployeeResource;
use App\Models\Department;
use App\Models\Employee;
use App\Models\InsuranceArea;
use App\Models\Job;
use App\Models\Nation;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeeController extends CommonController
{
    public function __construct(Request $request)
    {
        $action = $request->route()->getActionMethod();
        $this->middleware('can:' . $action . ',' . Employee::class);
        parent::__construct($request);
    }

    /**
     * 员工档案列表页
     * @param Department $department
     * @param Job $job
     * @return Application|Factory|View
     */
    public function list(Department $department, Job $job)
    {
        return view('admin.employee.list');
    }

    /**
     * 员工档案列表数据
     * @param Request $request
     * @param Employee $employee
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request, Employee $employee)
    {
        $where = array();
        if($request->has('action') && $request->input('action') == 'search'){
            parse_str($request->input('where'), $con);

            // 搜索条件
            if(!empty($con['name']))
                $where['name'] = ['like', '%'.$con['name'].'%'];
        }

        $employees = $employee->selectData($request->input('page'), $request->input('limit'), $where);

        return response()->json([
            'code' => RESPONSE_SUCCESS,
            'msg' => trans('request.success'),
            'count' => $employees['count'],
            'data' => EmployeeResource::collection($employees['data']),
        ], 200);
    }

    /**
     * 创建新员工档案
     * @param Request $request
     * @return Application|Factory|View
     */
    public function create(Department $department, Job $job, InsuranceArea $insurance_area, Nation $nation)
    {
        $departments = $department->all();
        $jobs = $job->all();
        $insurance_areas = $insurance_area->all();
        $nations = $nation->all();

        return view('admin.employee.create', [
            'departments' => $departments,
            'jobs' => $jobs,
            'insurance_areas' => $insurance_areas,
            'nations' => $nations,
        ]);
    }

    /**
     * 存储新员工档案
     * @param StoreEmployee $request
     * @param Employee $employee
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreEmployee $request, Employee $employee)
    {
        $employee->name = $request->input('name');

        return $this->returnOperationResponse($employee->save(), $request);
    }

    /**
     * 编辑员工档案
     * @param $id
     * @param Request $request
     * @param Employee $employee
     * @return Application|Factory|View
     */
    public function edit($id, Request $request, Employee $employee)
    {
        $employee = $employee->newQuery()->find($id);

        return view('admin.employee.edit', [
            'employee' => $employee,
        ]);
    }

    /**
     * 更新员工档案
     * @param UpdateEmployee $request
     * @param Employee $employee
     * @return \Illuminate\Http\JsonResponse
     * @throws DataNotExistsException
     */
    public function update(UpdateEmployee $request, Employee $employee)
    {
        try {
            $employee = $employee->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $employee->name = strval($request->input('name'));

        return $this->returnOperationResponse($employee->save(), $request);
    }

    /**
     * 删除员工档案
     * @param Request $request
     * @param Employee $employee
     * @return \Illuminate\Http\JsonResponse
     * @throws DataNotExistsException
     */
    public function delete(Request $request, Employee $employee)
    {
        try {
            $employee = $employee->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }
        return $this->returnOperationResponse($employee->delete(), $request);
    }
}
