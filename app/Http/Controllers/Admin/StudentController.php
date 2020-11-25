<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DataNotExistsException;
use App\Http\Requests\StoreStudent;
use App\Http\Requests\UpdateStudent;
use App\Http\Resources\ClassCourseResource;
use App\Http\Resources\StudentResource;
use App\Http\Resources\TQStudentResource;
use App\Models\ClassCourse;
use App\Models\Student;
use App\Models\StudentDiscount;
use App\Models\ClassType;
use App\Models\Department;
use App\Models\TQ;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Throwable;

class StudentController extends CommonController
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware('can:' . $this->request_action_name . ',' . Student::class);
    }

    /**
     * 班级列表页
     * @return Application|Factory|View
     */
    public function list()
    {
        return view('admin.student.list');
    }

    /**
     * 班级列表数据
     * @param Request $request
     * @param Student $student
     * @return JsonResponse
     */
    public function data(Request $request, Student $student)
    {
        // 制作搜索条件
        $where = $this->makeSearchConditions($request->input('where'));
        // 查询我的 或 我录入的学员信息
        $where['user_id'] = $this->user()->getAuthIdentifier();
        $where['person_in_charge'] = ['or', $this->user()->getAuthIdentifier()];
        // 查询数据
        $students = $student->selectData($request->input('page'), $request->input('limit'), $where);
        // 返回表格数据响应
        return $this->returnTableData($students, StudentResource::class);
    }

    /**
     * 查询账号所属TQ学员信息
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function search()
    {
        return view('admin.student.search');
    }

    /**
     * 账号所属TQ学员信息列表
     * @param Request $request
     * @param TQ $tq
     * @return JsonResponse
     */
    public function searched(Request $request, TQ $tq)
    {
        // 制作搜索条件
        $where = $this->makeSearchConditions($request->input('where'));
        // 若没有查询条件, 则返回空
        if(empty($where)) $where = ['id' => 0];
        // 查询数据
        $tq_students = $tq->selectData($request->input('page'), $request->input('limit'), $where);
        // 返回表格数据响应
        return $this->returnTableData($tq_students, TQStudentResource::class);
    }

    /**
     * 创建新班级
     * @param $id
     * @param Department $department
     * @param User $user
     * @param TQ $tq
     * @return Application|Factory|View
     */
    public function create($id, Department $department, User $user, TQ $tq)
    {
        try {
            $tq_student = $tq->newQuery()->findOrFail($id);
        } catch (Throwable $exception) {
            Log::error(trans('message.log.an empty query occurred'), ['class' => __CLASS__, 'id' => $id]);
            abort(404);
        }
        $departments = $department->all();
        $users = $user->all();
        return view('admin.student.create', [
            'departments' => $departments,
            'users' => $users,
            'tq_student' => $tq_student,
        ]);
    }

    /**
     * 选择班级表格表单
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function classCourses()
    {
        return view('admin.student.class_courses');
    }

    /**
     * 查询班级数据
     * @param Request $request
     * @param ClassCourse $class_course
     * @return JsonResponse
     */
    public function classCoursesData(Request $request, ClassCourse $class_course)
    {
        // 制作搜索条件
        $where = $this->makeSearchConditions($request->input('where'));
        // 查询数据
        $class_courses = $class_course->selectData($request->input('page'), $request->input('limit'), $where);
        // 返回表格数据响应
        return $this->returnTableData($class_courses, ClassCourseResource::class);
    }

    /**
     * 存储新班级
     * @param StoreStudent $request
     * @param Student $student
     * @param StudentDiscount $student_discount
     * @return JsonResponse
     */
    public function store(StoreStudent $request, Student $student, StudentDiscount $student_discount)
    {
        try {
            DB::transaction(function() use($request, $student, $student_discount) {
                // 存储学员信息
                $student->tq_id = strval($request->input('tq_id'));
                $student->name = strval($request->input('name'));
                $student->mobile = strval($request->input('mobile'));
                $student->ID_card_no = strval($request->input('ID_card_no'));
                $student->remark = strval($request->input('remark'));
                $student->class_course_id = intval($request->input('class_course_id'));
                $student->class_open_date = $request->input('class_open_date');
                $student->admission_ticket_no = strval($request->input('admission_ticket_no'));
                $student->applicant_company = strval($request->input('applicant_company'));
                $student->applicant_job = strval($request->input('applicant_job'));
                $student->applicant_num = intval($request->input('applicant_num'));
                $student->applicant_percent_molecule = intval($request->input('applicant_percent_molecule'));
                $student->applicant_percent_denominator = intval($request->input('applicant_percent_denominator'));
                $student->rank = intval($request->input('rank'));
                $student->difference = intval($request->input('difference'));
                $student->person_in_charge = intval($request->input('person_in_charge'));
                $student->campus = intval($request->input('campus'));
                $student->receivable_amount = floatval($request->input('receivable_amount'));
                $student->discount_amount = floatval($request->input('discount_amount'));
                $student->paid_amount = floatval($request->input('paid_amount'));
                $student->written_examination_refund = floatval($request->input('written_examination_refund'));
                $student->interview_refund = floatval($request->input('interview_refund'));
                $student->user_id = $this->user()->getAuthIdentifier();
                $student->save();

                // 存储学员优惠
                $class_examination_discount_ids = is_null($request->input('class_examination_discount_ids')) ? [] : explode(',' ,strval($request->input('class_examination_discount_ids')));
                $class_type_discount_ids = is_null($request->input('class_type_discount_ids')) ? [] : explode(',' ,strval($request->input('class_type_discount_ids')));

                $student_discounts = [];
                foreach($class_examination_discount_ids as $class_examination_discount_id) {
                    $student_discounts = ['student_id' => $student->id, 'discount_id' => $class_examination_discount_id, 'discount_type' => CLASS_EXAMINATION_DISCOUNT];
                }
                foreach($class_type_discount_ids as $class_type_discount_id) {
                    $student_discounts = ['student_id' => $student->id, 'discount_id' => $class_type_discount_id, 'discount_type' => CLASS_TYPE_DISCOUNT];
                }
                $student_discount->newQuery()->insert($student_discounts);
            });
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return $this->returnFailedResponse(trans('request.failed'), 500);
        }

        return $this->returnOperationResponse(true, $request);
    }

    /**
     * 编辑班级
     * @param $id
     * @param Student $student
     * @param ClassType $class_type
     * @param StudentType $student_type
     * @param Department $department
     * @return Application|Factory|View
     */
    public function edit($id, Student $student, ClassType $class_type, StudentType $student_type, Department $department)
    {
        $student = $student->newQuery()->findOrFail($id);
        $student_dates = implode(",", $student->student_dates()->toArray());
        $class_types = $class_type->allUsable();
        $student_types = $student_type->all();
        $departments = $department->all();

        return view('admin.student.edit', [
            'student' => $student,
            'class_types' => $class_types,
            'student_types' => $student_types,
            'departments' => $departments,
            'student_dates' => $student_dates
        ]);
    }

    /**
     * 更新班级
     * @param UpdateStudent $request
     * @param Student $student
     * @param StudentDate $student_date
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function update(UpdateStudent $request, Student $student, StudentDate $student_date)
    {
        try {
            $student = $student->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $dates = explode(',', strval($request->input('student_date')));

        try {
            DB::transaction(function() use($request, $student, $dates, $student_date) {
                $student->name = strval($request->input('name'));
                $student->class_type_id = intval($request->input('class_type_id'));
                $student->student_type_id = intval($request->input('student_type_id'));
                $student->department_id = intval($request->input('department_id'));
                $student->address = strval($request->input('address'));
                $student->day_num = count($dates);
                $student->max_person_num = intval($request->input('max_person_num'));
                $student->in_hotel = intval($request->input('in_hotel'));
                $student->in_hotel_date = $student->in_hotel == 1 ? $request->input('in_hotel_date') : null;
                $student->remark = strval($request->input('remark'));
                $student->save();

                $student_date->deleteFromId($student->id);
                foreach($dates as $date) {
                    $student_date->insert([
                        'student_id' => $student->id,
                        'student_date' => $date,
                    ]);
                }
            });
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return $this->returnFailedResponse(trans('request.failed'), 500);
        }

        return $this->returnOperationResponse(true, $request);
    }

    /**
     * 删除班级
     * @param Request $request
     * @param Student $student
     * @param StudentDate $student_date
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function delete(Request $request, Student $student, StudentDate $student_date)
    {
        try {
            $student = $student->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        try {
            DB::transaction(function() use($request, $student, $student_date) {
                $student_date->deleteFromId($student->id);
                $student->delete();
            });
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return $this->returnFailedResponse(trans('request.failed'), 500);
        }

        return $this->returnOperationResponse(true, $request);
    }
}
