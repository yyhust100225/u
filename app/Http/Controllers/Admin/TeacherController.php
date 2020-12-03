<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DataNotExistsException;
use App\Http\Requests\StoreTeacher;
use App\Http\Requests\UpdateTeacher;
use App\Http\Resources\TeacherResource;
use App\Models\CourseFee;
use App\Models\Teacher;
use App\Models\ClassType;
use App\Models\Department;
use App\Models\TeacherGroup;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Throwable;

class TeacherController extends CommonController
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware('can:' . $this->request_action_name . ',' . Teacher::class);
    }

    /**
     * 讲师列表页
     * @return Application|Factory|View
     */
    public function list()
    {
        return view('admin.teacher.list');
    }

    /**
     * 讲师列表数据
     * @param Request $request
     * @param Teacher $teacher
     * @return JsonResponse
     */
    public function data(Request $request, Teacher $teacher)
    {
        // 制作搜索条件
        $where = $this->makeSearchConditions($request->input('where'));
        // 查询数据
        $tq_students = $teacher->selectData($request->input('page'), $request->input('limit'), $where);
        // 返回表格数据响应
        return $this->returnTableData($tq_students, TeacherResource::class);
    }

    /**
     * 创建新讲师
     * @param CourseFee $course_fee
     * @param TeacherGroup $teacher_group
     * @return Application|Factory|View
     */
    public function create(CourseFee $course_fee, TeacherGroup $teacher_group)
    {
        $course_fees = $course_fee->all();
        $teacher_groups = $teacher_group->all();
        return view('admin.teacher.create', [
            'course_fees' => $course_fees,
            'teacher_groups' => $teacher_groups,
        ]);
    }

    /**
     * 存储新讲师
     * @param StoreTeacher $request
     * @param Teacher $teacher
     * @return JsonResponse
     */
    public function store(StoreTeacher $request, Teacher $teacher)
    {
        $teacher->name = strval($request->input('name'));
        $teacher->nickname = strval($request->input('nickname'));
        $teacher->tel = strval($request->input('tel'));
        $teacher->course_fee_id = intval($request->input('course_fee_id'));
        $teacher->teacher_group_id = intval($request->input('teacher_group_id'));
        $teacher->remark = strval($request->input('remark'));
        $teacher->user_id = $this->user()->getAuthIdentifier();

        return $this->returnOperationResponse($teacher->save(), $request);
    }

    /**
     * 编辑讲师
     * @param $id
     * @param Teacher $teacher
     * @param CourseFee $course_fee
     * @param TeacherGroup $teacher_group
     * @return Application|Factory|View
     */
    public function edit($id, Teacher $teacher, CourseFee $course_fee, TeacherGroup $teacher_group)
    {
        $teacher = $teacher->newQuery()->findOrFail($id);
        $course_fees = $course_fee->all();
        $teacher_groups = $teacher_group->all();
        return view('admin.teacher.edit', [
            'teacher' => $teacher,
            'course_fees' => $course_fees,
            'teacher_groups' => $teacher_groups,
        ]);
    }

    /**
     * 更新讲师
     * @param UpdateTeacher $request
     * @param Teacher $teacher
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function update(UpdateTeacher $request, Teacher $teacher)
    {
        try {
            $teacher = $teacher->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $teacher->name = strval($request->input('name'));
        $teacher->nickname = strval($request->input('nickname'));
        $teacher->tel = strval($request->input('tel'));
        $teacher->course_fee_id = intval($request->input('course_fee_id'));
        $teacher->teacher_group_id = intval($request->input('teacher_group_id'));
        $teacher->remark = strval($request->input('remark'));

        return $this->returnOperationResponse($teacher->save(), $request);
    }

    /**
     * 删除讲师
     * @param Request $request
     * @param Teacher $teacher
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function delete(Request $request, Teacher $teacher)
    {
        try {
            $teacher = $teacher->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        return $this->returnOperationResponse($teacher->delete(), $request);
    }
}
