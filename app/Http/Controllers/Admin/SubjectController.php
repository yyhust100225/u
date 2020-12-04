<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DataNotExistsException;
use App\Http\Requests\StoreSubject;
use App\Http\Requests\UpdateSubject;
use App\Http\Resources\SubjectResource;
use App\Models\CourseFee;
use App\Models\Subject;
use App\Models\Maps\MapSubjectToTeachers;
use App\Models\Teacher;
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

class SubjectController extends CommonController
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware('can:' . $this->request_action_name . ',' . Subject::class);
    }

    /**
     * 科目列表页
     * @return Application|Factory|View
     */
    public function list()
    {
        return view('admin.subject.list');
    }

    /**
     * 科目列表数据
     * @param Request $request
     * @param Subject $subject
     * @return JsonResponse
     */
    public function data(Request $request, Subject $subject): JsonResponse
    {
        // 制作搜索条件
        $where = $this->makeSearchConditions($request->input('where'));
        // 查询数据
        $subjects = $subject->selectData($request->input('page'), $request->input('limit'), $where);
        // 返回表格数据响应
        return $this->returnTableData($subjects, SubjectResource::class);
    }

    /**
     * 创建新科目
     * @param TeacherGroup $teacher_group
     * @return Application|Factory|View
     */
    public function create(TeacherGroup $teacher_group)
    {
        $teacher_groups = $teacher_group->with(['teachers' => function($query){
            $query->with('course_fee');
        }])->get();

        return view('admin.subject.create', [
            'teacher_groups' => $teacher_groups,
        ]);
    }

    /**
     * 存储新科目
     * @param StoreSubject $request
     * @param Subject $subject
     * @param MapSubjectToTeachers $mstt
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(StoreSubject $request, Subject $subject, MapSubjectToTeachers $mstt)
    {
        try {
            DB::transaction(function () use ($request, $subject, $mstt) {
                $subject->name = strval($request->input('name'));
                $subject->remark = strval($request->input('remark'));
                $subject->user_id = $this->user()->getAuthIdentifier();
                $subject->save();

                $teacher_ids = $request->input('teacher_ids');
                foreach ($teacher_ids as $teacher_id) {
                    $mstt->insert([
                        'subject_id' => $subject->id,
                        'teacher_id' => $teacher_id,
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
     * 编辑科目
     * @param $id
     * @param Subject $subject
     * @param CourseFee $course_fee
     * @param SubjectGroup $subject_group
     * @return Application|Factory|View
     */
    public function edit($id, Subject $subject, CourseFee $course_fee, SubjectGroup $subject_group)
    {
        $subject = $subject->newQuery()->findOrFail($id);
        $course_fees = $course_fee->all();
        $subject_groups = $subject_group->all();
        return view('admin.subject.edit', [
            'subject' => $subject,
            'course_fees' => $course_fees,
            'subject_groups' => $subject_groups,
        ]);
    }

    /**
     * 更新科目
     * @param UpdateSubject $request
     * @param Subject $subject
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function update(UpdateSubject $request, Subject $subject)
    {
        try {
            $subject = $subject->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $subject->name = strval($request->input('name'));
        $subject->nickname = strval($request->input('nickname'));
        $subject->tel = strval($request->input('tel'));
        $subject->course_fee_id = intval($request->input('course_fee_id'));
        $subject->subject_group_id = intval($request->input('subject_group_id'));
        $subject->remark = strval($request->input('remark'));

        return $this->returnOperationResponse($subject->save(), $request);
    }

    /**
     * 删除科目
     * @param Request $request
     * @param Subject $subject
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function delete(Request $request, Subject $subject): JsonResponse
    {
        try {
            $subject = $subject->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        return $this->returnOperationResponse($subject->delete(), $request);
    }
}
