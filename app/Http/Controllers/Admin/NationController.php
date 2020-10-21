<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DataNotExistsException;
use App\Http\Requests\StoreNation;
use App\Http\Requests\UpdateNation;
use App\Http\Resources\NationResource;
use App\Models\Nation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class NationController extends ProjectDepartmentController
{
    public function __construct(Request $request)
    {
        $action = $request->route()->getActionMethod();
        $this->middleware('can:' . $action . ',' . Nation::class);
        parent::__construct($request);
    }

    /**
     * 民族列表页
     * @param Request $request
     * @param Nation $nation
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(Request $request, Nation $nation)
    {
        return view('admin.nation.list');
    }

    /**
     * 民族列表数据
     * @param Request $request
     * @param Nation $nation
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request, Nation $nation)
    {
        $where = array();
        if($request->has('action') && $request->input('action') == 'search'){
            parse_str($request->input('where'), $con);

            // 搜索条件
            if(!empty($con['name']))
                $where['name'] = ['like', '%'.$con['name'].'%'];
        }

        $nations = $nation->selectData($request->input('page'), $request->input('limit'), $where);

        return response()->json([
            'code' => RESPONSE_SUCCESS,
            'msg' => trans('request.success'),
            'count' => $nations['count'],
            'data' => NationResource::collection($nations['data']),
        ], 200);
    }

    /**
     * 创建新民族
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('admin.nation.create');
    }

    /**
     * 存储新民族
     * @param StoreNation $request
     * @param Nation $nation
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreNation $request, Nation $nation)
    {
        $nation->name = $request->input('name');

        return $this->returnOperationResponse($nation->save(), $request);
    }

    /**
     * 编辑民族
     * @param $id
     * @param Request $request
     * @param Nation $nation
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, Request $request, Nation $nation)
    {
        $nation = $nation->newQuery()->find($id);

        return view('admin.nation.edit', [
            'nation' => $nation,
        ]);
    }

    /**
     * 更新民族
     * @param UpdateNation $request
     * @param Nation $nation
     * @return \Illuminate\Http\JsonResponse
     * @throws DataNotExistsException
     */
    public function update(UpdateNation $request, Nation $nation)
    {
        try {
            $nation = $nation->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $nation->name = strval($request->input('name'));

        return $this->returnOperationResponse($nation->save(), $request);
    }

    /**
     * 删除民族
     * @param Request $request
     * @param Nation $nation
     * @return \Illuminate\Http\JsonResponse
     * @throws DataNotExistsException
     */
    public function delete(Request $request, Nation $nation)
    {
        try {
            $nation = $nation->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }
        return $this->returnOperationResponse($nation->delete(), $request);
    }
}
