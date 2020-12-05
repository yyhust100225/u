<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DataNotExistsException;
use App\Http\Requests\StoreStudent;
use App\Http\Requests\UpdateStudent;
use App\Http\Resources\ClassCourseResource;
use App\Http\Resources\ClassTypeResource;
use App\Http\Resources\StudentResource;
use App\Http\Resources\TQStudentResource;
use App\Models\ClassCourse;
use App\Models\ClassType;
use App\Models\Student;
use App\Models\StudentDiscount;
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
     * 学员列表页
     * @return Application|Factory|View
     */
    public function list()
    {
        return view('admin.student.list');
    }

    /**
     * 学员列表数据
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
     * 创建新学员
     * @param $id
     * @param Student $student
     * @param Department $department
     * @param User $user
     * @param TQ $tq
     * @return Application|Factory|View
     */
    public function create($id, Student $student, Department $department, User $user, TQ $tq)
    {
        try {
            $tq_student = $tq->newQuery()->findOrFail($id);
        } catch (Throwable $exception) {
            Log::error(trans('message.log.an empty query occurred'), ['class' => __CLASS__, 'id' => $id]);
            abort(404);
        }

        // 判断TQID是否已录入
        if($student->tqIdExists($tq_student->tq_id)) {
            abort(403, trans('validation.tq_id_exists'));
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
     * 选择学院报名班型表单
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function classTypes()
    {
        return view('admin.student.class_types');
    }

    /**
     * 查询可报名班型数据
     * @param Request $request
     * @param ClassType $class_type
     * @return JsonResponse
     */
    public function classTypesData(Request $request, ClassType $class_type): JsonResponse
    {
        // 制作搜索条件
        $where = $this->makeSearchConditions($request->input('where'));
        // 查询数据
        $class_types = $class_type->selectData($request->input('page'), $request->input('limit'), $where);
        // 返回表格数据响应
        return $this->returnTableData($class_types, ClassTypeResource::class);
    }

    /**
     * 存储新学员
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
                $student->class_type_id = intval($request->input('class_type_id'));
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
                    $student_discounts[] = ['student_id' => $student->id, 'discount_id' => $class_examination_discount_id, 'discount_type' => CLASS_EXAMINATION_DISCOUNT];
                }
                foreach($class_type_discount_ids as $class_type_discount_id) {
                    $student_discounts[] = ['student_id' => $student->id, 'discount_id' => $class_type_discount_id, 'discount_type' => CLASS_TYPE_DISCOUNT];
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
     * 编辑学员
     * @param $id
     * @param Student $student
     * @param Department $department
     * @param User $user
     * @return Application|Factory|View
     */
    public function edit($id, Student $student, Department $department, User $user)
    {
        try {
            $student = $student->newQuery()->findOrFail($id);
        } catch (Throwable $exception) {
            Log::error(trans('message.log.an empty query occurred'), ['class' => __CLASS__, 'id' => $id]);
            abort(404);
        }

        // 当前学生考试+班型名称
        $student->class_type_name = trans('message.table.full class type name', [
            'examination_name' => $student->class_type->examination->name,
            'class_type_name' => $student->class_type->name,
        ]);

        // 学生已享优惠
        $student->class_examination_discount_ids = $student->discounts->where('discount_type', CLASS_EXAMINATION_DISCOUNT)->pluck('discount_id')->toArray();
        $student->class_type_discount_ids = $student->discounts->where('discount_type', CLASS_TYPE_DISCOUNT)->pluck('discount_id')->toArray();

        // 考试优惠
        $class_examination_discounts = $student->class_type->examination->discountsWithName();
        $class_type_discounts = $student->class_type->discounts;

        $departments = $department->all();
        $users = $user->all();
        return view('admin.student.edit', [
            'departments' => $departments,
            'users' => $users,
            'student' => $student,
            'class_examination_discounts' => $class_examination_discounts,
            'class_type_discounts' => $class_type_discounts,
        ]);
    }

    /**
     * 更新学员
     * @param UpdateStudent $request
     * @param Student $student
     * @param StudentDiscount $student_discount
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function update(UpdateStudent $request, Student $student, StudentDiscount $student_discount)
    {
        try {
            $student = $student->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            Log::error(trans('message.log.an empty query occurred'), ['class' => __CLASS__, 'id' => $request->input('id')]);
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        try {
            DB::transaction(function() use($request, $student, $student_discount) {
                // 存储学员信息
                $student->name = strval($request->input('name'));
                $student->mobile = strval($request->input('mobile'));
                $student->ID_card_no = strval($request->input('ID_card_no'));
                $student->remark = strval($request->input('remark'));
                $student->class_type_id = intval($request->input('class_type_id'));
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
                $student->save();

                // 删除原有优惠
                $student_discount->deleteDiscounts($student->id);

                // 存储学员优惠
                $class_examination_discount_ids = is_null($request->input('class_examination_discount_ids')) ? [] : explode(',' ,strval($request->input('class_examination_discount_ids')));
                $class_type_discount_ids = is_null($request->input('class_type_discount_ids')) ? [] : explode(',' ,strval($request->input('class_type_discount_ids')));

                $student_discounts = [];
                foreach($class_examination_discount_ids as $class_examination_discount_id) {
                    $student_discounts[] = ['student_id' => $student->id, 'discount_id' => $class_examination_discount_id, 'discount_type' => CLASS_EXAMINATION_DISCOUNT];
                }
                foreach($class_type_discount_ids as $class_type_discount_id) {
                    $student_discounts[] = ['student_id' => $student->id, 'discount_id' => $class_type_discount_id, 'discount_type' => CLASS_TYPE_DISCOUNT];
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
     * 删除学员
     * @param Request $request
     * @param Student $student
     * @param StudentDiscount $student_discount
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function delete(Request $request, Student $student, StudentDiscount $student_discount)
    {
        try {
            $student = $student->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        try {
            DB::transaction(function() use($request, $student, $student_discount) {
                $student_discount->deleteDiscounts($student->id);
                $student->delete();
            });
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return $this->returnFailedResponse(trans('request.failed'), 500);
        }
        return $this->returnOperationResponse(true, $request);
    }
}
