<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DataNotExistsException;
use App\Http\Requests\StoreClassCourse;
use App\Http\Requests\UpdateClassCourse;
use App\Http\Resources\ClassCourseResource;
use App\Models\ClassCourse;
use App\Models\ClassCourseType;
use App\Models\ClassType;
use App\Models\Department;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
     * @return JsonResponse
     */
    public function store(StoreClassCourse $request, ClassCourse $class_course)
    {
        $class_course->name = $request->input('name');

        return $this->returnOperationResponse($class_course->save(), $request);
    }

    /**
     * 编辑班级
     * @param $id
     * @param Request $request
     * @param ClassCourse $class_course
     * @return Application|Factory|View
     */
    public function edit($id, Request $request, ClassCourse $class_course)
    {
        $class_course = $class_course->newQuery()->find($id);

        return view('admin.class_course.edit', [
            'class_course' => $class_course,
        ]);
    }

    /**
     * 更新班级
     * @param UpdateClassCourse $request
     * @param ClassCourse $class_course
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function update(UpdateClassCourse $request, ClassCourse $class_course)
    {
        try {
            $class_course = $class_course->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $class_course->name = strval($request->input('name'));

        return $this->returnOperationResponse($class_course->save(), $request);
    }

    /**
     * 删除班级
     * @param Request $request
     * @param ClassCourse $class_course
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function delete(Request $request, ClassCourse $class_course)
    {
        try {
            $class_course = $class_course->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }
        return $this->returnOperationResponse($class_course->delete(), $request);
    }
}
