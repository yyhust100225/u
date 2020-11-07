<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DataNotExistsException;
use App\Http\Requests\StoreExamCategory;
use App\Http\Requests\UpdateExamCategory;
use App\Http\Resources\ExamCategoryResource;
use App\Models\ExamCategory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExamCategoryController extends ProjectDepartmentController
{
    public function __construct(Request $request)
    {
        $action = $request->route()->getActionMethod();
        $this->middleware('can:' . $action . ',' . ExamCategory::class);
        parent::__construct($request);
    }

    /**
     * 考试大类列表页
     * @param Request $request
     * @param ExamCategory $exam_category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(Request $request, ExamCategory $exam_category)
    {
        return view('admin.exam_category.exam_categories');
    }

    /**
     * 考试大类列表数据
     * @param Request $request
     * @param ExamCategory $exam_category
     * @return JsonResponse
     */
    public function data(Request $request, ExamCategory $exam_category)
    {
        $where = array();
        if($request->has('action') && $request->input('action') == 'search'){
            parse_str($request->input('where'), $con);

            // 搜索条件
            if(!empty($con['name']))
                $where['name'] = ['like', '%'.$con['name'].'%'];
        }

        $exam_categories = $exam_category->selectData($request->input('page'), $request->input('limit'), $where);

        return response()->json([
            'code' => RESPONSE_SUCCESS,
            'msg' => trans('request.success'),
            'count' => $exam_categories['count'],
            'data' => ExamCategoryResource::collection($exam_categories['data']),
        ], 200);
    }

    /**
     * 创建新考试大类
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {

        return view('admin.exam_category.create');
    }

    /**
     * 存储新考试大类
     * @param StoreExamCategory $request
     * @param ExamCategory $exam_category
     * @return JsonResponse
     */
    public function store(StoreExamCategory $request, ExamCategory $exam_category)
    {
        $exam_category->name = strval($request->input('name'));
        $exam_category->remark = strval($request->input('remark'));

        return $this->returnOperationResponse($exam_category->save(), $request);
    }

    /**
     * 编辑考试大类
     * @param $id
     * @param Request $request
     * @param ExamCategory $exam_category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, Request $request, ExamCategory $exam_category)
    {
        $exam_category = $exam_category->newQuery()->find($id);

        return view('admin.exam_category.edit', [
            'exam_category' => $exam_category,
        ]);
    }

    /**
     * 更新考试大类
     * @param UpdateExamCategory $request
     * @param ExamCategory $exam_category
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function update(UpdateExamCategory $request, ExamCategory $exam_category)
    {
        try {
            $exam_category = $exam_category->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $exam_category->name = strval($request->input('name'));
        $exam_category->remark = strval($request->input('remark'));

        return $this->returnOperationResponse($exam_category->save(), $request);
    }

    /**
     * 删除考试大类
     * @param Request $request
     * @param ExamCategory $exam_category
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function delete(Request $request, ExamCategory $exam_category)
    {
        try {
            $exam_category = $exam_category->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }
        return $this->returnOperationResponse($exam_category->delete(), $request);
    }
}
