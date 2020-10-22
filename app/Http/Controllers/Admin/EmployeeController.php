<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DataNotExistsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployee;
use App\Http\Requests\UpdateEmployee;
use App\Http\Resources\EmployeeResource;
use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeeDeparture;
use App\Models\EmployeeEducation;
use App\Models\EmployeeSalary;
use App\Models\InsuranceArea;
use App\Models\Job;
use App\Models\Nation;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Mockery\Exception;
use Throwable;

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
     * @return JsonResponse
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
     * @param Department $department
     * @param Job $job
     * @param InsuranceArea $insurance_area
     * @param Nation $nation
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
     * @param EmployeeDeparture $employee_departure
     * @param EmployeeEducation $employee_education
     * @param EmployeeSalary $employee_salary
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(StoreEmployee $request, Employee $employee, EmployeeDeparture $employee_departure, EmployeeEducation $employee_education, EmployeeSalary $employee_salary)
    {
        try {
            DB::transaction(function () use ($request, $employee, $employee_departure, $employee_education, $employee_salary) {
                $employee->name = strval($request->input('name'));
                $employee->job_no = strval($request->input('job_no'));
                $employee->TQ_no = strval($request->input('TQ_no'));
                $employee->department_id = intval($request->input('department_id'));
                $employee->group_id = intval($request->input('group_id'));
                $employee->job_id = intval($request->input('job_id'));
                $employee->level = strval($request->input('level'));
                $employee->staff_no = strval($request->input('staff_no'));
                $employee->mic_no = strval($request->input('mic_no'));
                $employee->paf_no = strval($request->input('paf_no'));
                $employee->status = intval($request->input('status'));
                $employee->hire_date = $request->input('hire_date');
                $employee->last_contract_date = $request->input('last_contract_date');
                $employee->contract_expire_date = $request->input('contract_expire_date');
                $employee->regular = intval($request->input('regular'));
                $employee->regular_date = $request->input('regular_date');
                $employee->insurance_area_id = intval($request->input('insurance_area_id'));
                $employee->insurance_date = $request->input('insurance_date');
                $employee->gender = intval($request->input('gender'));
                $employee->nation_id = intval($request->input('nation'));
                $employee->political_status = intval($request->input('political_status'));
                $employee->marry = intval($request->input('marry'));
                $employee->register_residence_type = intval($request->input('register_residence_type'));
                $employee->id_card_no = strval($request->input('id_card_no'));
                $employee->tel = strval($request->input('tel'));
                $employee->birthday = $request->input('birthday');
                $employee->alias = strval($request->input('alias'));
                $employee->teacher_certification = intval($request->input('teacher_certification'));
                $employee->emergency_contact = strval($request->input('emergency_contact'));
                $employee->emergency_tel = strval($request->input('emergency_tel'));
                $employee->id_card_address = strval($request->input('id_card_address'));
                $employee->current_address = strval($request->input('current_address'));
                $employee->work_experience = strval($request->input('work_experience'));
                $employee->remark = strval($request->input('remark'));
                $employee->bank_card_no_5 = strval($request->input('bank_card_no_5'));
                $employee->bank_of_account_5 = strval($request->input('bank_of_account_5'));
                $employee->bank_card_no_10 = strval($request->input('bank_card_no_10'));
                $employee->bank_of_account_10 = strval($request->input('bank_of_account_10'));
                $employee->exception_action = strval($request->input('exception_action'));
                $employee->leave_records = strval($request->input('leave_records'));
                $employee->save();

                $employee_departure->employee_id = $employee->id;
                $employee_departure->departure_date = $request->input('departure_date');
                $employee_departure->departure_type = intval($request->input('departure_type'));
                $employee_departure->direction = strval($request->input('direction'));
                $employee_departure->conversation_content = strval($request->input('conversation_content'));
                $employee_departure->save();

                $employee_education->employee_id = $employee->id;
                $employee_education->educational_background = strval($request->input('educational_background'));
                $employee_education->academic_degree = strval($request->input('academic_degree'));
                $employee_education->major = strval($request->input('major'));
                $employee_education->university = strval($request->input('university'));
                $employee_education->learn_model = strval($request->input('learn_model'));
                $employee_education->graduate_date = $request->input('graduate_date');
                $employee_education->other_certificates = strval($request->input('other_certificates'));
                $employee_education->save();

                $employee_salary->employee_id = $employee->id;
                $employee_salary->base_salary_1 = floatval($request->input('base_salary_1'));
                $employee_salary->base_salary_2 = floatval($request->input('base_salary_2'));
                $employee_salary->merits_salary = floatval($request->input('merits_salary'));
                $employee_salary->job_subsidy = floatval($request->input('job_subsidy'));
                $employee_salary->live_subsidy = floatval($request->input('live_subsidy'));
                $employee_salary->local_subsidy = floatval($request->input('local_subsidy'));
                $employee_salary->public_service_subsidy = floatval($request->input('public_service_subsidy'));
                $employee_salary->class_subsidy = floatval($request->input('class_subsidy'));
                $employee_salary->no_insurance_subsidy = floatval($request->input('no_insurance_subsidy'));
                $employee_salary->other_subsidy = floatval($request->input('other_subsidy'));
                $employee_salary->save();
            });
        } catch (\Exception $exception) {
            return $this->returnFailedResponse($exception->getMessage(), 500);
        }
        return $this->returnOperationResponse(true, $request);
    }

    /**
     * 编辑员工档案
     * @param $id
     * @param Employee $employee
     * @param Department $department
     * @param Job $job
     * @param InsuranceArea $insurance_area
     * @param Nation $nation
     * @return Application|Factory|View
     */
    public function edit($id, Employee $employee, Department $department, Job $job, InsuranceArea $insurance_area, Nation $nation)
    {
        $employee = $employee->newQuery()->with(['departure', 'education', 'salary'])->find($id);

        $departments = $department->all();
        $jobs = $job->all();
        $insurance_areas = $insurance_area->all();
        $nations = $nation->all();

        return view('admin.employee.edit', [
            'employee' => $employee,
            'departments' => $departments,
            'jobs' => $jobs,
            'insurance_areas' => $insurance_areas,
            'nations' => $nations,
        ]);
    }

    /**
     * 更新员工档案
     * @param UpdateEmployee $request
     * @param Employee $employee
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function update(UpdateEmployee $request, Employee $employee)
    {
        try {
            $employee = $employee->newQuery()->with(['departure', 'education', 'salary'])->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        try {
            DB::transaction(function () use ($request, $employee) {
                $employee->name = strval($request->input('name'));
                $employee->job_no = strval($request->input('job_no'));
                $employee->TQ_no = strval($request->input('TQ_no'));
                $employee->department_id = intval($request->input('department_id'));
                $employee->group_id = intval($request->input('group_id'));
                $employee->job_id = intval($request->input('job_id'));
                $employee->level = strval($request->input('level'));
                $employee->staff_no = strval($request->input('staff_no'));
                $employee->mic_no = strval($request->input('mic_no'));
                $employee->paf_no = strval($request->input('paf_no'));
                $employee->status = intval($request->input('status'));
                $employee->hire_date = $request->input('hire_date');
                $employee->last_contract_date = $request->input('last_contract_date');
                $employee->contract_expire_date = $request->input('contract_expire_date');

                $employee->regular = intval($request->input('regular'));
                if($employee->regular == 0)
                    $employee->regular_date = null;
                else
                    $employee->regular_date = $request->input('regular_date');

                $employee->insurance_area_id = intval($request->input('insurance_area_id'));
                if($employee->insurance_area_id == 0)
                    $employee->insurance_date = null;
                else
                    $employee->insurance_date = $request->input('insurance_date');

                $employee->gender = intval($request->input('gender'));
                $employee->nation_id = intval($request->input('nation'));
                $employee->political_status = intval($request->input('political_status'));
                $employee->marry = intval($request->input('marry'));
                $employee->register_residence_type = intval($request->input('register_residence_type'));
                $employee->id_card_no = strval($request->input('id_card_no'));
                $employee->tel = strval($request->input('tel'));
                $employee->birthday = $request->input('birthday');
                $employee->alias = strval($request->input('alias'));
                $employee->teacher_certification = intval($request->input('teacher_certification'));
                $employee->emergency_contact = strval($request->input('emergency_contact'));
                $employee->emergency_tel = strval($request->input('emergency_tel'));
                $employee->id_card_address = strval($request->input('id_card_address'));
                $employee->current_address = strval($request->input('current_address'));
                $employee->work_experience = strval($request->input('work_experience'));
                $employee->remark = strval($request->input('remark'));
                $employee->bank_card_no_5 = strval($request->input('bank_card_no_5'));
                $employee->bank_of_account_5 = strval($request->input('bank_of_account_5'));
                $employee->bank_card_no_10 = strval($request->input('bank_card_no_10'));
                $employee->bank_of_account_10 = strval($request->input('bank_of_account_10'));
                $employee->exception_action = strval($request->input('exception_action'));
                $employee->leave_records = strval($request->input('leave_records'));
                $employee->save();

                if($employee->status != 2) {
                    $employee->departure->departure_date = null;
                    $employee->departure->departure_type = 0;
                    $employee->departure->direction = '';
                    $employee->departure->conversation_content = '';
                } else {
                    $employee->departure->departure_date = $request->input('departure_date');
                    $employee->departure->departure_type = intval($request->input('departure_type'));
                    $employee->departure->direction = strval($request->input('direction'));
                    $employee->departure->conversation_content = strval($request->input('conversation_content'));
                }
                $employee->departure->save();

                $employee->education->educational_background = strval($request->input('educational_background'));
                $employee->education->academic_degree = strval($request->input('academic_degree'));
                $employee->education->major = strval($request->input('major'));
                $employee->education->university = strval($request->input('university'));
                $employee->education->learn_model = strval($request->input('learn_model'));
                $employee->education->graduate_date = $request->input('graduate_date');
                $employee->education->other_certificates = strval($request->input('other_certificates'));
                $employee->education->save();

                $employee->salary->base_salary_1 = floatval($request->input('base_salary_1'));
                $employee->salary->base_salary_2 = floatval($request->input('base_salary_2'));
                $employee->salary->merits_salary = floatval($request->input('merits_salary'));
                $employee->salary->job_subsidy = floatval($request->input('job_subsidy'));
                $employee->salary->live_subsidy = floatval($request->input('live_subsidy'));
                $employee->salary->local_subsidy = floatval($request->input('local_subsidy'));
                $employee->salary->public_service_subsidy = floatval($request->input('public_service_subsidy'));
                $employee->salary->class_subsidy = floatval($request->input('class_subsidy'));
                $employee->salary->no_insurance_subsidy = floatval($request->input('no_insurance_subsidy'));
                $employee->salary->other_subsidy = floatval($request->input('other_subsidy'));
                $employee->salary->save();
            });
        } catch (\Exception $exception) {
            return $this->returnFailedResponse($exception->getMessage(), 500);
        }

        return $this->returnOperationResponse(true, $request);
    }

    /**
     * 删除员工档案
     * @param Request $request
     * @param Employee $employee
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function delete(Request $request, Employee $employee)
    {
        try {
            $employee = $employee->newQuery()->with(['departure', 'education', 'salary'])->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        try {
            DB::transaction(function () use ($employee) {
                $employee->education->delete();
                $employee->departure->delete();
                $employee->salary->delete();
                $employee->delete();
            });
        } catch (Throwable $e) {
            return $this->returnFailedResponse($e->getMessage(), 500);
        }

        return $this->returnOperationResponse(true, $request);
    }
}
