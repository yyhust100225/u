<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DataNotExistsException;
use App\Http\Requests\StoreInsuranceArea;
use App\Http\Requests\UpdateInsuranceArea;
use App\Http\Resources\InsuranceAreaResource;
use App\Models\InsuranceArea;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class InsuranceAreaController extends ProjectDepartmentController
{
    public function __construct(Request $request)
    {
        $action = $request->route()->getActionMethod();
        $this->middleware('can:' . $action . ',' . InsuranceArea::class);
        parent::__construct($request);
    }

    /**
     * 保险地区列表页
     * @param Request $request
     * @param InsuranceArea $insurance_area
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(Request $request, InsuranceArea $insurance_area)
    {
        return view('admin.insurance_area.list');
    }

    /**
     * 保险地区列表数据
     * @param Request $request
     * @param InsuranceArea $insurance_area
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request, InsuranceArea $insurance_area)
    {
        $where = array();
        if($request->has('action') && $request->input('action') == 'search'){
            parse_str($request->input('where'), $con);

            // 搜索条件
            if(!empty($con['name']))
                $where['name'] = ['like', '%'.$con['name'].'%'];
        }

        $insurance_areas = $insurance_area->selectData($request->input('page'), $request->input('limit'), $where);

        return response()->json([
            'code' => RESPONSE_SUCCESS,
            'msg' => trans('request.success'),
            'count' => $insurance_areas['count'],
            'data' => InsuranceAreaResource::collection($insurance_areas['data']),
        ], 200);
    }

    /**
     * 创建新保险地区
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('admin.insurance_area.create');
    }

    /**
     * 存储新保险地区
     * @param StoreInsuranceArea $request
     * @param InsuranceArea $insurance_area
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreInsuranceArea $request, InsuranceArea $insurance_area)
    {
        $insurance_area->name = $request->input('name');

        return $this->returnOperationResponse($insurance_area->save(), $request);
    }

    /**
     * 编辑保险地区
     * @param $id
     * @param Request $request
     * @param InsuranceArea $insurance_area
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, Request $request, InsuranceArea $insurance_area)
    {
        $insurance_area = $insurance_area->newQuery()->find($id);

        return view('admin.insurance_area.edit', [
            'insurance_area' => $insurance_area,
        ]);
    }

    /**
     * 更新保险地区
     * @param UpdateInsuranceArea $request
     * @param InsuranceArea $insurance_area
     * @return \Illuminate\Http\JsonResponse
     * @throws DataNotExistsException
     */
    public function update(UpdateInsuranceArea $request, InsuranceArea $insurance_area)
    {
        try {
            $insurance_area = $insurance_area->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $insurance_area->name = strval($request->input('name'));

        return $this->returnOperationResponse($insurance_area->save(), $request);
    }

    /**
     * 删除保险地区
     * @param Request $request
     * @param InsuranceArea $insurance_area
     * @return \Illuminate\Http\JsonResponse
     * @throws DataNotExistsException
     */
    public function delete(Request $request, InsuranceArea $insurance_area)
    {
        try {
            $insurance_area = $insurance_area->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }
        return $this->returnOperationResponse($insurance_area->delete(), $request);
    }
}
