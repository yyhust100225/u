<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DataNotExistsException;
use App\Http\Requests\OptMateriel;
use App\Http\Requests\StoreMateriel;
use App\Http\Requests\UpdateMateriel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\Materiel;
use App\Http\Resources\MaterielResource;
use App\Models\Department;

class MaterielController extends ProjectDepartmentController
{
    public function __construct(Request $request)
    {
        $action = $request->route()->getActionMethod();
        $this->middleware('can:' . $action . ',' . Materiel::class);
        parent::__construct($request);
    }

    /**
     * 物料物料列表页
     * @param Request $request
     * @param Materiel $materiel
     * @return Application|Factory|\Illuminate\View\View
     */
    public function list(Request $request, Materiel $materiel)
    {
        return view('admin.materiel.materiels');
    }

    /**
     * 物料物料列表数据
     * @param Request $request
     * @param Materiel $materiel
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request, Materiel $materiel)
    {
        $where = array();
        if($request->has('action') && $request->input('action') == 'search'){
            parse_str($request->input('where'), $con);

            // 搜索条件
            if(!empty($con['name']))
                $where['name'] = ['like', '%'.$con['name'].'%'];
        }

        $materiels = $materiel->selectData($request->input('page'), $request->input('limit'), $where);

        return response()->json([
            'code' => RESPONSE_SUCCESS,
            'msg' => trans('request.success'),
            'count' => $materiels['count'],
            'data' => MaterielResource::collection($materiels['data']),
        ], 200);
    }

    /**
     * 创建新物料物料
     * @param Request $request
     * @param Department $department
     * @return Application|Factory|\Illuminate\View\View
     */
    public function create(Request $request, Department $department)
    {
        $departments = $department->all();
        return view('admin.materiel.create', [
            'departments' => $departments,
        ]);
    }

    /**
     * 存储物料物料
     * @param StoreMateriel $request
     * @param Materiel $materiel
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreMateriel $request, Materiel $materiel)
    {
        $materiel->name = $request->input('name');
        $materiel->department_id = $request->input('department_id');
        $materiel->quantity_total = $request->input('quantity_total');
        $materiel->quantity_scrap = $request->input('quantity_scrap');
        $materiel->quantity_consume = $request->input('quantity_consume');
        $materiel->quantity_incomplete = $request->input('quantity_incomplete');
        $materiel->quantity_usable = $request->input('quantity_total') - $request->input('quantity_scrap') - $request->input('quantity_consume') - $request->input('quantity_incomplete');

        return $this->returnOperationResponse($materiel->save(), $request);
    }

    /**
     * 编辑物料物料
     * @param $id
     * @param Request $request
     * @param Materiel $materiel
     * @param Department $department
     * @return Application|Factory|\Illuminate\View\View
     */
    public function edit($id, Request $request, Materiel $materiel, Department $department)
    {
        $materiel = $materiel->newQuery()->find($id);
        $departments = $department->all();
        return view('admin.materiel.edit', [
            'materiel' => $materiel,
            'departments' => $departments,
        ]);
    }

    /**
     * 更新物料物料
     * @param UpdateMateriel $request
     * @param Materiel $materiel
     * @return \Illuminate\Http\JsonResponse
     * @throws DataNotExistsException
     */
    public function update(UpdateMateriel $request, Materiel $materiel)
    {
        try {
            $materiel = $materiel->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $materiel->name = $request->input('name');
        $materiel->department_id = $request->input('department_id');
        $materiel->quantity_total = $request->input('quantity_total');
        $materiel->quantity_scrap = $request->input('quantity_scrap');
        $materiel->quantity_consume = $request->input('quantity_consume');
        $materiel->quantity_incomplete = $request->input('quantity_incomplete');
        $materiel->quantity_usable = $request->input('quantity_total') - $request->input('quantity_scrap') - $request->input('quantity_consume') - $request->input('quantity_incomplete');

        return $this->returnOperationResponse($materiel->save(), $request);
    }

    /**
     * 删除物料物料
     * @param Request $request
     * @param Materiel $materiel
     * @return \Illuminate\Http\JsonResponse
     * @throws DataNotExistsException
     */
    public function delete(Request $request, Materiel $materiel)
    {
        try {
            $materiel = $materiel->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }
        return $this->returnOperationResponse($materiel->delete(), $request);
    }

    /**
     * 增加物料数量
     * @param $id
     * @param Request $request
     * @param Materiel $materiel
     * @return Application|Factory|\Illuminate\View\View
     */
    public function increase($id, Request $request, Materiel $materiel)
    {
        $materiel = $materiel->newQuery()->find($id);
        return view('admin.materiel.increase', [
            'materiel' => $materiel,
        ]);
    }

    /**
     * 补充物料数量
     * @param OptMateriel $request
     * @param Materiel $materiel
     * @return \Illuminate\Http\JsonResponse
     * @throws DataNotExistsException
     */
    public function supplement(OptMateriel $request, Materiel $materiel)
    {
        try {
            $materiel = $materiel->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $materiel->quantity_total = $materiel->quantity_total + $request->input('quantity_supplement');
        $materiel->quantity_usable = $materiel->quantity_usable + $request->input('quantity_supplement');

        return $this->returnOperationResponse($materiel->save(), $request);
    }

    /**
     * 减少物料数量
     * @param $id
     * @param Request $request
     * @param Materiel $materiel
     * @return Application|Factory|\Illuminate\View\View
     */
    public function decrease($id, Request $request, Materiel $materiel)
    {
        $materiel = $materiel->newQuery()->find($id);
        return view('admin.materiel.decrease', [
            'materiel' => $materiel,
        ]);
    }

    /**
     * 消耗物料数量
     * @param OptMateriel $request
     * @param Materiel $materiel
     * @return \Illuminate\Http\JsonResponse
     * @throws DataNotExistsException
     */
    public function consume(OptMateriel $request, Materiel $materiel)
    {
        try {
            $materiel = $materiel->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $materiel->quantity_scrap = $materiel->quantity_scrap + $request->input('quantity_scrap');
        $materiel->quantity_consume = $materiel->quantity_consume + $request->input('quantity_consume');
        $materiel->quantity_incomplete = $materiel->quantity_incomplete + $request->input('quantity_incomplete');
        $materiel->quantity_usable = $materiel->quantity_usable - $request->input('quantity_scrap') - $request->input('quantity_consume') - $request->input('quantity_incomplete');

        return $this->returnOperationResponse($materiel->save(), $request);
    }
}
