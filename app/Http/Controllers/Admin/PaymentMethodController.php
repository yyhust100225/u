<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DataNotExistsException;
use App\Http\Requests\StorePaymentMethod;
use App\Http\Requests\UpdatePaymentMethod;
use App\Http\Resources\PaymentMethodResource;
use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentMethodController extends ProjectDepartmentController
{
    public function __construct(Request $request)
    {
        $action = $request->route()->getActionMethod();
        $this->middleware('can:' . $action . ',' . PaymentMethod::class);
        parent::__construct($request);
    }

    /**
     * 考试列表页
     * @param Request $request
     * @param PaymentMethod $payment_method
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(Request $request, PaymentMethod $payment_method)
    {
        return view('admin.payment_method.list');
    }

    /**
     * 考试列表数据
     * @param Request $request
     * @param PaymentMethod $payment_method
     * @return JsonResponse
     */
    public function data(Request $request, PaymentMethod $payment_method)
    {
        $where = array();
        if($request->has('action') && $request->input('action') == 'search'){
            parse_str($request->input('where'), $con);

            // 搜索条件
            if(!empty($con['name']))
                $where['name'] = ['like', '%'.$con['name'].'%'];
        }

        $payment_methods = $payment_method->selectData($request->input('page'), $request->input('limit'), $where);

        return response()->json([
            'code' => RESPONSE_SUCCESS,
            'msg' => trans('request.success'),
            'count' => $payment_methods['count'],
            'data' => PaymentMethodResource::collection($payment_methods['data']),
        ], 200);
    }

    /**
     * 创建新考试
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('admin.payment_method.create');
    }

    /**
     * 存储新考试
     * @param StorePaymentMethod $request
     * @param PaymentMethod $payment_method
     * @return JsonResponse
     */
    public function store(StorePaymentMethod $request, PaymentMethod $payment_method)
    {
        $payment_method->name = $request->input('name');
        return $this->returnOperationResponse($payment_method->save(), $request);
    }

    /**
     * 编辑考试
     * @param $id
     * @param Request $request
     * @param PaymentMethod $payment_method
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, Request $request, PaymentMethod $payment_method)
    {
        $payment_method = $payment_method->newQuery()->find($id);

        return view('admin.payment_method.edit', [
            'payment_method' => $payment_method,
        ]);
    }

    /**
     * 更新考试
     * @param UpdatePaymentMethod $request
     * @param PaymentMethod $payment_method
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function update(UpdatePaymentMethod $request, PaymentMethod $payment_method)
    {
        try {
            $payment_method = $payment_method->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $payment_method->name = strval($request->input('name'));

        return $this->returnOperationResponse($payment_method->save(), $request);
    }

    /**
     * 删除考试
     * @param Request $request
     * @param PaymentMethod $payment_method
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function delete(Request $request, PaymentMethod $payment_method)
    {
        try {
            $payment_method = $payment_method->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }
        return $this->returnOperationResponse($payment_method->delete(), $request);
    }
}
