<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DataNotExistsException;
use App\Http\Requests\StoreJob;
use App\Http\Requests\UpdateJob;
use App\Http\Resources\JobResource;
use App\Models\Job;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class JobController extends ProjectDepartmentController
{
    public function __construct(Request $request)
    {
        $action = $request->route()->getActionMethod();
        $this->middleware('can:' . $action . ',' . Job::class);
        parent::__construct($request);
    }

    /**
     * 职务列表页
     * @param Request $request
     * @param Job $job
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(Request $request, Job $job)
    {
        return view('admin.job.list');
    }

    /**
     * 职务列表数据
     * @param Request $request
     * @param Job $job
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request, Job $job)
    {
        $where = array();
        if($request->has('action') && $request->input('action') == 'search'){
            parse_str($request->input('where'), $con);

            // 搜索条件
            if(!empty($con['name']))
                $where['name'] = ['like', '%'.$con['name'].'%'];
        }

        $jobs = $job->selectData($request->input('page'), $request->input('limit'), $where);

        return response()->json([
            'code' => RESPONSE_SUCCESS,
            'msg' => trans('request.success'),
            'count' => $jobs['count'],
            'data' => JobResource::collection($jobs['data']),
        ], 200);
    }

    /**
     * 创建新职务
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('admin.job.create');
    }

    /**
     * 存储新职务
     * @param StoreJob $request
     * @param Job $job
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreJob $request, Job $job)
    {
        $job->name = $request->input('name');
        $job->type = $request->input('type');

        return $this->returnOperationResponse($job->save(), $request);
    }

    /**
     * 编辑职务
     * @param $id
     * @param Request $request
     * @param Job $job
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, Request $request, Job $job)
    {
        $job = $job->newQuery()->find($id);

        return view('admin.job.edit', [
            'job' => $job,
        ]);
    }

    /**
     * 更新职务
     * @param UpdateJob $request
     * @param Job $job
     * @return \Illuminate\Http\JsonResponse
     * @throws DataNotExistsException
     */
    public function update(UpdateJob $request, Job $job)
    {
        try {
            $job = $job->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $job->name = strval($request->input('name'));
        $job->type = intval($request->input('type'));

        return $this->returnOperationResponse($job->save(), $request);
    }

    /**
     * 删除职务
     * @param Request $request
     * @param Job $job
     * @return \Illuminate\Http\JsonResponse
     * @throws DataNotExistsException
     */
    public function delete(Request $request, Job $job)
    {
        try {
            $job = $job->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }
        return $this->returnOperationResponse($job->delete(), $request);
    }
}
