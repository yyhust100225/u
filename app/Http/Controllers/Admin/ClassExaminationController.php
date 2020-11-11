<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DataNotExistsException;
use App\Http\Requests\StoreClassExamination;
use App\Http\Requests\StoreClassExaminationDiscount;
use App\Http\Requests\UpdateClassExamination;
use App\Http\Requests\UpdateClassExaminationDiscount;
use App\Http\Resources\ClassTypeDiscountResource;
use App\Http\Resources\ClassTypeResource;
use App\Models\City;
use App\Models\ClassAnnouncement;
use App\Models\ClassExamination;
use App\Models\ClassExaminationDiscount;
use App\Models\ClassExaminationDiscountType;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ClassExaminationController extends ProjectDepartmentController
{
    public function __construct(Request $request)
    {
        $action = $request->route()->getActionMethod();
        $this->middleware('can:' . $action . ',' . ClassExamination::class);
        parent::__construct($request);
    }

    /**
     * 考试列表页
     * @param Request $request
     * @param ClassExamination $class_examination
     * @return Application|Factory|View
     */
    public function list(Request $request, ClassExamination $class_examination)
    {
        return view('admin.class_examination.list');
    }

    /**
     * 考试列表数据
     * @param Request $request
     * @param ClassExamination $class_examination
     * @return JsonResponse
     */
    public function data(Request $request, ClassExamination $class_examination)
    {
        $where = array();
        if($request->has('action') && $request->input('action') == 'search'){
            parse_str($request->input('where'), $con);

            // 搜索条件
            if(!empty($con['title']))
                $where['title'] = ['like', '%'.$con['title'].'%'];
        }

        $class_examinations = $class_examination->selectData($request->input('page'), $request->input('limit'), $where);

        return response()->json([
            'code' => RESPONSE_SUCCESS,
            'msg' => trans('request.success'),
            'count' => $class_examinations['count'],
            'data' => ClassTypeResource::collection($class_examinations['data']),
        ], 200);
    }

    /**
     * 创建新考试
     * @param Request $request
     * @param ClassAnnouncement $announcement
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function create(Request $request, ClassAnnouncement $announcement)
    {
        $announcements = $announcement->allUsable();

        return view('admin.class_examination.create', [
            'announcements' => $announcements,
        ]);
    }

    /**
     * 存储新考试
     * @param StoreClassExamination $request
     * @param ClassExamination $class_examination
     * @return JsonResponse
     */
    public function store(StoreClassExamination $request, ClassExamination $class_examination)
    {
        $class_examination->name = strval($request->input('name'));
        $class_examination->announcement_id = intval($request->input('announcement_id'));
        $class_examination->remark = strval($request->input('remark'));
        $class_examination->status = intval($request->input('status'));
        $class_examination->user_id = $this->user()->getAuthIdentifier();

        return $this->returnOperationResponse($class_examination->save(), $request);
    }

    /**
     * 编辑考试
     * @param $id
     * @param Request $request
     * @param ClassExamination $class_examination
     * @param ClassAnnouncement $announcement
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id, Request $request, ClassExamination $class_examination, ClassAnnouncement $announcement)
    {
        $class_examination = $class_examination->newQuery()->find($id);
        $announcements = $announcement->allUsableWithOne($class_examination->announcement_id);

        return view('admin.class_examination.edit', [
            'class_examination' => $class_examination,
            'announcements' => $announcements,
        ]);
    }

    /**
     * 更新考试
     * @param UpdateClassExamination $request
     * @param ClassExamination $class_examination
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function update(UpdateClassExamination $request, ClassExamination $class_examination)
    {
        try {
            $class_examination = $class_examination->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $class_examination->name = strval($request->input('name'));
        $class_examination->announcement_id = intval($request->input('announcement_id'));
        $class_examination->remark = strval($request->input('remark'));
        $class_examination->status = intval($request->input('status'));
        $class_examination->user_id = $this->user()->getAuthIdentifier();

        return $this->returnOperationResponse($class_examination->save(), $request);
    }

    /**
     * 删除考试
     * @param Request $request
     * @param ClassExamination $class_examination
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function delete(Request $request, ClassExamination $class_examination)
    {
        try {
            $class_examination = $class_examination->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        try {
            DB::transaction(function() use($class_examination) {
                $class_examination->discounts()->delete();
                $class_examination->delete();
            });
        } catch (\Throwable $e) {
            return $this->returnFailedResponse($e->getMessage(), 500);
        }

        return $this->returnOperationResponse(true, $request);
    }

    /**
     * 考试优惠列表页
     * @param $id
     * @param Request $request
     * @param ClassExaminationDiscountType $type
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function discounts($id, Request $request, ClassExaminationDiscountType $type)
    {
        $types = $type->all();

        return view('admin.class_examination.discounts', [
            'examination_id' => $id,
            'types' => $types,
        ]);
    }

    /**
     * 考试优惠列表数据
     * @param Request $request
     * @param ClassExaminationDiscount $class_examination_discount
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function discountsData(Request $request, ClassExaminationDiscount $class_examination_discount)
    {
        if(!$examination_id = $request->input('examination_id'))
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);

        $where = array('examination_id' => $examination_id);
        if($request->has('action') && $request->input('action') == 'search'){
            parse_str($request->input('where'), $con);

            // 搜索条件
            if(!empty($con['discount_type_id']))
                $where['discount_type_id'] = $con['discount_type_id'];
        }

        $class_examination_discounts = $class_examination_discount->selectData($request->input('page'), $request->input('limit'), $where);

        return response()->json([
            'code' => RESPONSE_SUCCESS,
            'msg' => trans('request.success'),
            'count' => $class_examination_discounts['count'],
            'data' => ClassTypeDiscountResource::collection($class_examination_discounts['data']),
        ], 200);
    }

    /**
     * 创建新考试优惠
     * @param $examination_id
     * @param ClassExaminationDiscountType $type
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function discountCreate($examination_id, ClassExaminationDiscountType $type)
    {
        $types = $type->all();
        return view('admin.class_examination.discount_create', [
            'examination_id' => $examination_id,
            'types' => $types
        ]);
    }

    /**
     * 存储新考试优惠
     * @param StoreClassExaminationDiscount $request
     * @param ClassExaminationDiscount $discount
     * @return JsonResponse
     */
    public function discountStore(StoreClassExaminationDiscount $request, ClassExaminationDiscount $discount)
    {
        $discount->examination_id = intval($request->input('examination_id'));
        $discount->discount_type_id = intval($request->input('discount_type_id'));
        $discount->amount = floatval($request->input('amount'));
        $discount->status = intval($request->input('status'));
        $discount->user_id = $this->user()->getAuthIdentifier();
        $discount->remark = strval($request->input('remark'));

        return $this->returnOperationResponse($discount->save(), $request);
    }

    /**
     * 编辑考试优惠
     * @param $id
     * @param ClassExaminationDiscount $discount
     * @param ClassExaminationDiscountType $type
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function discountEdit($id, ClassExaminationDiscount $discount, ClassExaminationDiscountType $type)
    {
        $discount = $discount->newQuery()->find($id);
        $types = $type->all();

        return view('admin.class_examination.discount_edit', [
            'discount' => $discount,
            'types' => $types
        ]);
    }

    /**
     * 更新考试优惠
     * @param UpdateClassExaminationDiscount $request
     * @param ClassExaminationDiscount $discount
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function discountUpdate(UpdateClassExaminationDiscount $request, ClassExaminationDiscount $discount)
    {
        try {
            $discount = $discount->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $discount->discount_type_id = intval($request->input('discount_type_id'));
        $discount->amount = floatval($request->input('amount'));
        $discount->status = intval($request->input('status'));
        $discount->remark = strval($request->input('remark'));

        return $this->returnOperationResponse($discount->save(), $request);
    }

    /**
     * 删除考试优惠
     * @param Request $request
     * @param ClassExaminationDiscount $discount
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function discountDelete(Request $request, ClassExaminationDiscount $discount)
    {
        try {
            $discount = $discount->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }
        return $this->returnOperationResponse($discount->delete(), $request);
    }
}
