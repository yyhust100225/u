<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DataNotExistsException;
use App\Http\Requests\StoreCity;
use App\Http\Requests\UpdateCity;
use App\Http\Resources\CityResource;
use App\Models\City;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CityController extends ProjectDepartmentController
{
    public function __construct(Request $request)
    {
        $action = $request->route()->getActionMethod();
        $this->middleware('can:' . $action . ',' . City::class);
        parent::__construct($request);
    }

    /**
     * 城市列表页
     * @param Request $request
     * @param City $city
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(Request $request, City $city)
    {
        return view('admin.city.list');
    }

    /**
     * 城市列表数据
     * @param Request $request
     * @param City $city
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request, City $city)
    {
        $where = array();
        if($request->has('action') && $request->input('action') == 'search'){
            parse_str($request->input('where'), $con);

            // 搜索条件
            if(!empty($con['name']))
                $where['name'] = ['like', '%'.$con['name'].'%'];
        }

        $cities = $city->selectData($request->input('page'), $request->input('limit'), $where);

        return response()->json([
            'code' => RESPONSE_SUCCESS,
            'msg' => trans('request.success'),
            'count' => $cities['count'],
            'data' => CityResource::collection($cities['data']),
        ], 200);
    }

    /**
     * 创建新城市
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('admin.city.create');
    }

    /**
     * 存储新城市
     * @param StoreCity $request
     * @param City $city
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCity $request, City $city)
    {
        $city->name = $request->input('name');

        return $this->returnOperationResponse($city->save(), $request);
    }

    /**
     * 编辑城市
     * @param $id
     * @param Request $request
     * @param City $city
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, Request $request, City $city)
    {
        $city = $city->newQuery()->find($id);

        return view('admin.city.edit', [
            'city' => $city,
        ]);
    }

    /**
     * 更新城市
     * @param UpdateCity $request
     * @param City $city
     * @return \Illuminate\Http\JsonResponse
     * @throws DataNotExistsException
     */
    public function update(UpdateCity $request, City $city)
    {
        try {
            $city = $city->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $city->name = strval($request->input('name'));

        return $this->returnOperationResponse($city->save(), $request);
    }

    /**
     * 删除城市
     * @param Request $request
     * @param City $city
     * @return \Illuminate\Http\JsonResponse
     * @throws DataNotExistsException
     */
    public function delete(Request $request, City $city)
    {
        try {
            $city = $city->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }
        return $this->returnOperationResponse($city->delete(), $request);
    }
}
