<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DataNotExistsException;
use App\Http\Requests\StoreClassType;
use App\Http\Requests\StoreClassTypeDiscount;
use App\Http\Requests\UpdateClassType;
use App\Http\Requests\UpdateClassTypeDiscount;
use App\Http\Resources\ClassTypeDiscountResource;
use App\Http\Resources\ClassTypeResource;
use App\Models\ClassAnnouncement;
use App\Models\ClassExamination;
use App\Models\ClassType;
use App\Models\ClassTypeDiscount;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ClassTypeController extends ProjectDepartmentController
{
    public function __construct(Request $request)
    {
        $action = $request->route()->getActionMethod();
        $this->middleware('can:' . $action . ',' . ClassType::class);
        parent::__construct($request);
    }

    /**
     * 班型列表页
     * @param Request $request
     * @param ClassType $class_type
     * @return Application|Factory|View
     */
    public function list(Request $request, ClassType $class_type)
    {
        return view('admin.class_type.list');
    }

    /**
     * 班型列表数据
     * @param Request $request
     * @param ClassType $class_type
     * @return JsonResponse
     */
    public function data(Request $request, ClassType $class_type)
    {
        $where = array();
        if($request->has('action') && $request->input('action') == 'search'){
            parse_str($request->input('where'), $con);

            // 搜索条件
            if(!empty($con['name']))
                $where['name'] = ['like', '%'.$con['name'].'%'];
        }

        $class_types = $class_type->selectData($request->input('page'), $request->input('limit'), $where);

        return response()->json([
            'code' => RESPONSE_SUCCESS,
            'msg' => trans('request.success'),
            'count' => $class_types['count'],
            'data' => ClassTypeResource::collection($class_types['data']),
        ], 200);
    }

    /**
     * 创建新班型
     * @param Request $request
     * @param ClassExamination $examination
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function create(Request $request, ClassExamination $examination)
    {
        $examinations = $examination->allUsable();

        return view('admin.class_type.create', [
            'examinations' => $examinations,
        ]);
    }

    /**
     * 存储新班型
     * @param StoreClassType $request
     * @param ClassType $class_type
     * @return JsonResponse
     */
    public function store(StoreClassType $request, ClassType $class_type)
    {
        $class_type->name = strval($request->input('name'));
        $class_type->examination_id = intval($request->input('examination_id'));
        $class_type->is_agreement_class = intval($request->input('is_agreement_class'));
        $class_type->exam_type = intval($request->input('exam_type'));
        $class_type->written_examination_days = intval($request->input('written_examination_days'));
        $class_type->written_examination_nights = intval($request->input('written_examination_nights'));
        $class_type->interview_days = intval($request->input('interview_days'));
        $class_type->interview_nights = intval($request->input('interview_nights'));
        $class_type->total_tuition = floatval($request->input('total_tuition'));
        $class_type->per_day_tuition = floatval($request->input('per_day_tuition'));
        $class_type->written_examination_refund = floatval($request->input('written_examination_refund'));
        $class_type->interview_refund = floatval($request->input('interview_refund'));
        $class_type->remark = strval($request->input('remark'));
        $class_type->status = intval($request->input('status'));
        $class_type->user_id = $this->user()->getAuthIdentifier();

        return $this->returnOperationResponse($class_type->save(), $request);
    }

    /**
     * 编辑班型
     * @param $id
     * @param Request $request
     * @param ClassType $class_type
     * @param ClassExamination $examination
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id, Request $request, ClassType $class_type, ClassExamination $examination)
    {
        $class_type = $class_type->newQuery()->find($id);
        $examinations = $examination->allUsableWithOne($class_type->examination_id);

        return view('admin.class_type.edit', [
            'class_type' => $class_type,
            'examinations' => $examinations,
        ]);
    }

    /**
     * 更新班型
     * @param UpdateClassType $request
     * @param ClassType $class_type
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function update(UpdateClassType $request, ClassType $class_type)
    {
        try {
            $class_type = $class_type->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $class_type->name = strval($request->input('name'));
        $class_type->examination_id = intval($request->input('examination_id'));
        $class_type->is_agreement_class = intval($request->input('is_agreement_class'));
        $class_type->exam_type = intval($request->input('exam_type'));
        $class_type->written_examination_days = intval($request->input('written_examination_days'));
        $class_type->written_examination_nights = intval($request->input('written_examination_nights'));
        $class_type->interview_days = intval($request->input('interview_days'));
        $class_type->interview_nights = intval($request->input('interview_nights'));
        $class_type->total_tuition = floatval($request->input('total_tuition'));
        $class_type->per_day_tuition = floatval($request->input('per_day_tuition'));
        $class_type->written_examination_refund = floatval($request->input('written_examination_refund'));
        $class_type->interview_refund = floatval($request->input('interview_refund'));
        $class_type->remark = strval($request->input('remark'));
        $class_type->status = intval($request->input('status'));
        $class_type->user_id = $this->user()->getAuthIdentifier();

        return $this->returnOperationResponse($class_type->save(), $request);
    }

    /**
     * 删除班型
     * @param Request $request
     * @param ClassType $class_type
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function delete(Request $request, ClassType $class_type)
    {
        try {
            $class_type = $class_type->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        try {
            DB::transaction(function() use($class_type) {
                $class_type->discounts()->delete();
                $class_type->delete();
            });
        } catch (\Throwable $e) {
            return $this->returnFailedResponse($e->getMessage(), 500);
        }

        return $this->returnOperationResponse(true, $request);
    }

    /**
     * 班型优惠列表页
     * @param $id
     * @param Request $request
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function discounts($id, Request $request)
    {
        return view('admin.class_type.discounts', [
            'type_id' => $id,
        ]);
    }

    /**
     * 班型优惠列表数据
     * @param Request $request
     * @param ClassTypeDiscount $class_type_discount
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function discountsData(Request $request, ClassTypeDiscount $class_type_discount)
    {
        if(!$type_id = $request->input('type_id'))
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);

        $where = array('type_id' => $type_id);
        if($request->has('action') && $request->input('action') == 'search'){
            parse_str($request->input('where'), $con);

            // 搜索条件
            if(!empty($con['name']))
                $where['name'] = ['like', '%'.$con['name'].'%'];
        }

        $class_type_discounts = $class_type_discount->selectData($request->input('page'), $request->input('limit'), $where);

        return response()->json([
            'code' => RESPONSE_SUCCESS,
            'msg' => trans('request.success'),
            'count' => $class_type_discounts['count'],
            'data' => ClassTypeDiscountResource::collection($class_type_discounts['data']),
        ], 200);
    }

    /**
     * 创建新班型优惠
     * @param $type_id
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function discountCreate($type_id)
    {
        return view('admin.class_type.discount_create', [
            'type_id' => $type_id,
        ]);
    }

    /**
     * 存储新班型优惠
     * @param StoreClassTypeDiscount $request
     * @param ClassTypeDiscount $discount
     * @return JsonResponse
     */
    public function discountStore(StoreClassTypeDiscount $request, ClassTypeDiscount $discount)
    {
        $discount->type_id = intval($request->input('type_id'));
        $discount->name = strval($request->input('name'));
        $discount->amount = floatval($request->input('amount'));
        $discount->start_date = $request->input('start_date');
        $discount->end_date = $request->input('end_date');
        $discount->status = intval($request->input('status'));
        $discount->user_id = $this->user()->getAuthIdentifier();
        $discount->remark = strval($request->input('remark'));

        return $this->returnOperationResponse($discount->save(), $request);
    }

    /**
     * 编辑班型优惠
     * @param $id
     * @param ClassTypeDiscount $discount
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function discountEdit($id, ClassTypeDiscount $discount)
    {
        $discount = $discount->newQuery()->find($id);

        return view('admin.class_type.discount_edit', [
            'discount' => $discount,
        ]);
    }

    /**
     * 更新班型优惠
     * @param UpdateClassTypeDiscount $request
     * @param ClassTypeDiscount $discount
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function discountUpdate(UpdateClassTypeDiscount $request, ClassTypeDiscount $discount)
    {
        try {
            $discount = $discount->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $discount->name = strval($request->input('name'));
        $discount->amount = floatval($request->input('amount'));
        $discount->start_date = $request->input('start_date');
        $discount->end_date = $request->input('end_date');
        $discount->status = intval($request->input('status'));
        $discount->user_id = $this->user()->getAuthIdentifier();
        $discount->remark = strval($request->input('remark'));

        return $this->returnOperationResponse($discount->save(), $request);
    }

    /**
     * 删除班型优惠
     * @param Request $request
     * @param ClassTypeDiscount $discount
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function discountDelete(Request $request, ClassTypeDiscount $discount)
    {
        try {
            $discount = $discount->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }
        return $this->returnOperationResponse($discount->delete(), $request);
    }
}
