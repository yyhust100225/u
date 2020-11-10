<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DataNotExistsException;
use App\Http\Requests\StoreExam;
use App\Http\Requests\UpdateExam;
use App\Http\Resources\ExamResource;
use App\Models\Exam;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExamController extends ProjectDepartmentController
{
    public function __construct(Request $request)
    {
        $action = $request->route()->getActionMethod();
        $this->middleware('can:' . $action . ',' . Exam::class);
        parent::__construct($request);
    }

    /**
     * 考试列表页
     * @param Request $request
     * @param Exam $exam
     * @return Application|Factory|View
     */
    public function list(Request $request, Exam $exam)
    {
        return view('admin.exam.list');
    }

    /**
     * 考试列表数据
     * @param Request $request
     * @param Exam $exam
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request, Exam $exam)
    {
        $where = array();
        if($request->has('action') && $request->input('action') == 'search'){
            parse_str($request->input('where'), $con);

            // 搜索条件
            if(!empty($con['name']))
                $where['name'] = ['like', '%'.$con['name'].'%'];
        }

        $exams = $exam->selectData($request->input('page'), $request->input('limit'), $where);

        return response()->json([
            'code' => RESPONSE_SUCCESS,
            'msg' => trans('request.success'),
            'count' => $exams['count'],
            'data' => ExamResource::collection($exams['data']),
        ], 200);
    }

    /**
     * 创建新考试
     * @param Request $request
     * @return Application|Factory|View
     */
    public function create(Request $request)
    {
        return view('admin.exam.create');
    }

    /**
     * 存储新考试
     * @param StoreExam $request
     * @param Exam $exam
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreExam $request, Exam $exam)
    {
        $exam->name = $request->input('name');

        return $this->returnOperationResponse($exam->save(), $request);
    }

    /**
     * 编辑考试
     * @param $id
     * @param Request $request
     * @param Exam $exam
     * @return Application|Factory|View
     */
    public function edit($id, Request $request, Exam $exam)
    {
        $exam = $exam->newQuery()->find($id);

        return view('admin.exam.edit', [
            'exam' => $exam,
        ]);
    }

    /**
     * 更新考试
     * @param UpdateExam $request
     * @param Exam $exam
     * @return \Illuminate\Http\JsonResponse
     * @throws DataNotExistsException
     */
    public function update(UpdateExam $request, Exam $exam)
    {
        try {
            $exam = $exam->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $exam->name = strval($request->input('name'));

        return $this->returnOperationResponse($exam->save(), $request);
    }

    /**
     * 删除考试
     * @param Request $request
     * @param Exam $exam
     * @return \Illuminate\Http\JsonResponse
     * @throws DataNotExistsException
     */
    public function delete(Request $request, Exam $exam)
    {
        try {
            $exam = $exam->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }
        return $this->returnOperationResponse($exam->delete(), $request);
    }
}
