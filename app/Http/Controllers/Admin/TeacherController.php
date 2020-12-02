<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DataNotExistsException;
use App\Http\Requests\StoreTeacher;
use App\Http\Requests\UpdateTeacher;
use App\Http\Resources\TeacherResource;
use App\Models\Teacher;
use App\Models\TeacherDate;
use App\Models\TeacherType;
use App\Models\ClassType;
use App\Models\Department;
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
     * @param ClassType $class_type
     * @param TeacherType $teacher_type
     * @param Department $department
     * @return Application|Factory|View
     */
    public function create(ClassType $class_type, TeacherType $teacher_type, Department $department)
    {
        $class_types = $class_type->allUsable();
        $teacher_types = $teacher_type->all();
        $departments = $department->all();
        return view('admin.teacher.create', [
            'class_types' => $class_types,
            'teacher_types' => $teacher_types,
            'departments' => $departments,
        ]);
    }

    /**
     * 存储新讲师
     * @param StoreTeacher $request
     * @param Teacher $teacher
     * @param TeacherDate $teacher_date
     * @return JsonResponse
     */
    public function store(StoreTeacher $request, Teacher $teacher, TeacherDate $teacher_date)
    {
        $dates = explode(',', strval($request->input('teacher_date')));

        try {
            DB::transaction(function() use($request, $teacher, $dates, $teacher_date) {
                $teacher->name = strval($request->input('name'));
                $teacher->class_type_id = intval($request->input('class_type_id'));
                $teacher->teacher_type_id = intval($request->input('teacher_type_id'));
                $teacher->department_id = intval($request->input('department_id'));
                $teacher->address = strval($request->input('address'));
                $teacher->day_num = count($dates);
                $teacher->max_person_num = intval($request->input('max_person_num'));
                $teacher->in_hotel = intval($request->input('in_hotel'));
                $teacher->in_hotel_date = $teacher->in_hotel == 1 ? $request->input('in_hotel_date') : null;
                $teacher->remark = strval($request->input('remark'));
                $teacher->save();

                foreach($dates as $date) {
                    $teacher_date->insert([
                        'teacher_id' => $teacher->id,
                        'teacher_date' => $date,
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
     * 编辑讲师
     * @param $id
     * @param Teacher $teacher
     * @param ClassType $class_type
     * @param TeacherType $teacher_type
     * @param Department $department
     * @return Application|Factory|View
     */
    public function edit($id, Teacher $teacher, ClassType $class_type, TeacherType $teacher_type, Department $department)
    {
        $teacher = $teacher->newQuery()->findOrFail($id);
        $teacher_dates = implode(",", $teacher->teacher_dates()->toArray());
        $class_types = $class_type->allUsable();
        $teacher_types = $teacher_type->all();
        $departments = $department->all();

        return view('admin.teacher.edit', [
            'teacher' => $teacher,
            'class_types' => $class_types,
            'teacher_types' => $teacher_types,
            'departments' => $departments,
            'teacher_dates' => $teacher_dates
        ]);
    }

    /**
     * 更新讲师
     * @param UpdateTeacher $request
     * @param Teacher $teacher
     * @param TeacherDate $teacher_date
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function update(UpdateTeacher $request, Teacher $teacher, TeacherDate $teacher_date)
    {
        try {
            $teacher = $teacher->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $dates = explode(',', strval($request->input('teacher_date')));

        try {
            DB::transaction(function() use($request, $teacher, $dates, $teacher_date) {
                $teacher->name = strval($request->input('name'));
                $teacher->class_type_id = intval($request->input('class_type_id'));
                $teacher->teacher_type_id = intval($request->input('teacher_type_id'));
                $teacher->department_id = intval($request->input('department_id'));
                $teacher->address = strval($request->input('address'));
                $teacher->day_num = count($dates);
                $teacher->max_person_num = intval($request->input('max_person_num'));
                $teacher->in_hotel = intval($request->input('in_hotel'));
                $teacher->in_hotel_date = $teacher->in_hotel == 1 ? $request->input('in_hotel_date') : null;
                $teacher->remark = strval($request->input('remark'));
                $teacher->save();

                $teacher_date->deleteFromId($teacher->id);
                foreach($dates as $date) {
                    $teacher_date->insert([
                        'teacher_id' => $teacher->id,
                        'teacher_date' => $date,
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
     * 删除讲师
     * @param Request $request
     * @param Teacher $teacher
     * @param TeacherDate $teacher_date
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function delete(Request $request, Teacher $teacher, TeacherDate $teacher_date)
    {
        try {
            $teacher = $teacher->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        try {
            DB::transaction(function() use($request, $teacher, $teacher_date) {
                $teacher_date->deleteFromId($teacher->id);
                $teacher->delete();
            });
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return $this->returnFailedResponse(trans('request.failed'), 500);
        }

        return $this->returnOperationResponse(true, $request);
    }
}
