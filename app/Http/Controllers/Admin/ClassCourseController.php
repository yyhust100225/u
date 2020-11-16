<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DataNotExistsException;
use App\Http\Requests\StoreClassCourse;
use App\Http\Requests\UpdateClassCourse;
use App\Http\Resources\ClassCourseResource;
use App\Models\ClassCourse;
use App\Models\ClassCourseDate;
use App\Models\ClassCourseType;
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

class ClassCourseController extends ProjectDepartmentController
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware('can:' . $this->request_action_name . ',' . ClassCourse::class);
    }

    /**
     * 班级列表页
     * @return Application|Factory|View
     */
    public function list()
    {
        return view('admin.class_course.list');
    }

    /**
     * 班级列表数据
     * @param Request $request
     * @param ClassCourse $class_course
     * @return JsonResponse
     */
    public function data(Request $request, ClassCourse $class_course)
    {
        // 制作搜索条件
        $where = $this->makeSearchConditions($request->input('where'));
        // 查询数据
        $tq_students = $class_course->selectData($request->input('page'), $request->input('limit'), $where);
        // 返回表格数据响应
        return $this->returnTableData($tq_students, ClassCourseResource::class);
    }

    /**
     * 创建新班级
     * @param ClassType $class_type
     * @param ClassCourseType $class_course_type
     * @param Department $department
     * @return Application|Factory|View
     */
    public function create(ClassType $class_type, ClassCourseType $class_course_type, Department $department)
    {
        $class_types = $class_type->allUsable();
        $class_course_types = $class_course_type->all();
        $departments = $department->all();
        return view('admin.class_course.create', [
            'class_types' => $class_types,
            'class_course_types' => $class_course_types,
            'departments' => $departments,
        ]);
    }

    /**
     * 存储新班级
     * @param StoreClassCourse $request
     * @param ClassCourse $class_course
     * @param ClassCourseDate $class_course_date
     * @return JsonResponse
     */
    public function store(StoreClassCourse $request, ClassCourse $class_course, ClassCourseDate $class_course_date)
    {
        $dates = explode(',', strval($request->input('class_course_date')));

        try {
            DB::transaction(function() use($request, $class_course, $dates, $class_course_date) {
                $class_course->name = strval($request->input('name'));
                $class_course->class_type_id = intval($request->input('class_type_id'));
                $class_course->class_course_type_id = intval($request->input('class_course_type_id'));
                $class_course->department_id = intval($request->input('department_id'));
                $class_course->address = strval($request->input('address'));
                $class_course->day_num = count($dates);
                $class_course->max_person_num = intval($request->input('max_person_num'));
                $class_course->in_hotel = intval($request->input('in_hotel'));
                $class_course->in_hotel_date = $class_course->in_hotel == 1 ? $request->input('in_hotel_date') : null;
                $class_course->remark = strval($request->input('remark'));
                $class_course->save();

                foreach($dates as $date) {
                    $class_course_date->insert([
                        'class_course_id' => $class_course->id,
                        'class_course_date' => $date,
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
     * 编辑班级
     * @param $id
     * @param ClassCourse $class_course
     * @param ClassType $class_type
     * @param ClassCourseType $class_course_type
     * @param Department $department
     * @return Application|Factory|View
     */
    public function edit($id, ClassCourse $class_course, ClassType $class_type, ClassCourseType $class_course_type, Department $department)
    {
        $class_course = $class_course->newQuery()->findOrFail($id);
        $class_course_dates = implode(",", $class_course->class_course_dates()->toArray());
        $class_types = $class_type->allUsable();
        $class_course_types = $class_course_type->all();
        $departments = $department->all();

        return view('admin.class_course.edit', [
            'class_course' => $class_course,
            'class_types' => $class_types,
            'class_course_types' => $class_course_types,
            'departments' => $departments,
            'class_course_dates' => $class_course_dates
        ]);
    }

    /**
     * 更新班级
     * @param UpdateClassCourse $request
     * @param ClassCourse $class_course
     * @param ClassCourseDate $class_course_date
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function update(UpdateClassCourse $request, ClassCourse $class_course, ClassCourseDate $class_course_date)
    {
        try {
            $class_course = $class_course->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $dates = explode(',', strval($request->input('class_course_date')));

        try {
            DB::transaction(function() use($request, $class_course, $dates, $class_course_date) {
                $class_course->name = strval($request->input('name'));
                $class_course->class_type_id = intval($request->input('class_type_id'));
                $class_course->class_course_type_id = intval($request->input('class_course_type_id'));
                $class_course->department_id = intval($request->input('department_id'));
                $class_course->address = strval($request->input('address'));
                $class_course->day_num = count($dates);
                $class_course->max_person_num = intval($request->input('max_person_num'));
                $class_course->in_hotel = intval($request->input('in_hotel'));
                $class_course->in_hotel_date = $class_course->in_hotel == 1 ? $request->input('in_hotel_date') : null;
                $class_course->remark = strval($request->input('remark'));
                $class_course->save();

                $class_course_date->deleteFromId($class_course->id);
                foreach($dates as $date) {
                    $class_course_date->insert([
                        'class_course_id' => $class_course->id,
                        'class_course_date' => $date,
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
     * @param ClassCourse $class_course
     * @param ClassCourseDate $class_course_date
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function delete(Request $request, ClassCourse $class_course, ClassCourseDate $class_course_date)
    {
        try {
            $class_course = $class_course->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        try {
            DB::transaction(function() use($request, $class_course, $class_course_date) {
                $class_course_date->deleteFromId($class_course->id);
                $class_course->delete();
            });
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return $this->returnFailedResponse(trans('request.failed'), 500);
        }

        return $this->returnOperationResponse(true, $request);
    }
}
