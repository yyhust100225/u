<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DataNotExistsException;
use App\Http\Requests\StoreNoticeType;
use App\Http\Requests\UpdateNoticeType;
use App\Http\Resources\NoticeTypeResource;
use App\Models\NoticeType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class NoticeTypeController extends ProjectDepartmentController
{
    public function __construct(Request $request)
    {
        $action = $request->route()->getActionMethod();
        $this->middleware('can:' . $action . ',' . NoticeType::class);
        parent::__construct($request);
    }

    /**
     * 通知类型列表页
     * @param Request $request
     * @param NoticeType $notice_type
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(Request $request, NoticeType $notice_type)
    {
        return view('admin.notice_type.list');
    }

    /**
     * 通知类型列表数据
     * @param Request $request
     * @param NoticeType $notice_type
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request, NoticeType $notice_type)
    {
        $where = array();
        if($request->has('action') && $request->input('action') == 'search'){
            parse_str($request->input('where'), $con);

            // 搜索条件
            if(!empty($con['name']))
                $where['name'] = ['like', '%'.$con['name'].'%'];
        }

        $notice_types = $notice_type->selectData($request->input('page'), $request->input('limit'), $where);

        return response()->json([
            'code' => RESPONSE_SUCCESS,
            'msg' => trans('request.success'),
            'count' => $notice_types['count'],
            'data' => NoticeTypeResource::collection($notice_types['data']),
        ], 200);
    }

    /**
     * 创建新通知类型
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('admin.notice_type.create');
    }

    /**
     * 存储新通知类型
     * @param StoreNoticeType $request
     * @param NoticeType $notice_type
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreNoticeType $request, NoticeType $notice_type)
    {
        $notice_type->name = $request->input('name');

        return $this->returnOperationResponse($notice_type->save(), $request);
    }

    /**
     * 编辑通知类型
     * @param $id
     * @param Request $request
     * @param NoticeType $notice_type
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, Request $request, NoticeType $notice_type)
    {
        $notice_type = $notice_type->newQuery()->find($id);

        return view('admin.notice_type.edit', [
            'notice_type' => $notice_type,
        ]);
    }

    /**
     * 更新通知类型
     * @param UpdateNoticeType $request
     * @param NoticeType $notice_type
     * @return \Illuminate\Http\JsonResponse
     * @throws DataNotExistsException
     */
    public function update(UpdateNoticeType $request, NoticeType $notice_type)
    {
        try {
            $notice_type = $notice_type->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $notice_type->name = strval($request->input('name'));

        return $this->returnOperationResponse($notice_type->save(), $request);
    }

    /**
     * 删除通知类型
     * @param Request $request
     * @param NoticeType $notice_type
     * @return \Illuminate\Http\JsonResponse
     * @throws DataNotExistsException
     */
    public function delete(Request $request, NoticeType $notice_type)
    {
        try {
            $notice_type = $notice_type->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }
        return $this->returnOperationResponse($notice_type->delete(), $request);
    }
}
