<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DataNotExistsException;
use App\Http\Requests\StoreClassExaminationDiscount;
use App\Http\Requests\UpdateClassExaminationDiscount;
use App\Http\Resources\ClassExaminationDiscountResource;
use App\Models\City;
use App\Models\ClassAnnouncement;
use App\Models\ClassExaminationDiscount;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ClassExaminationDiscountController extends ProjectDepartmentController
{
    public function __construct(Request $request)
    {
        $action = $request->route()->getActionMethod();
        $this->middleware('can:' . $action . ',' . ClassExaminationDiscount::class);
        parent::__construct($request);
    }

    /**
     * 考试优惠列表页
     * @param Request $request
     * @param ClassExaminationDiscount $class_examination_discount
     * @return Application|Factory|View
     */
    public function list(Request $request, ClassExaminationDiscount $class_examination_discount)
    {
        return view('admin.class_examination_discount.list');
    }

    /**
     * 考试优惠列表数据
     * @param Request $request
     * @param ClassExaminationDiscount $class_examination_discount
     * @return JsonResponse
     */
    public function data(Request $request, ClassExaminationDiscount $class_examination_discount)
    {
        $where = array();
        if($request->has('action') && $request->input('action') == 'search'){
            parse_str($request->input('where'), $con);

            // 搜索条件
            if(!empty($con['title']))
                $where['title'] = ['like', '%'.$con['title'].'%'];
        }

        $class_examination_discounts = $class_examination_discount->selectData($request->input('page'), $request->input('limit'), $where);

        return response()->json([
            'code' => RESPONSE_SUCCESS,
            'msg' => trans('request.success'),
            'count' => $class_examination_discounts['count'],
            'data' => ClassExaminationDiscountResource::collection($class_examination_discounts['data']),
        ], 200);
    }

    /**
     * 创建新考试优惠
     * @param Request $request
     * @param ClassAnnouncement $announcement
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function create(Request $request, ClassAnnouncement $announcement)
    {
        $announcements = $announcement->allUsable();

        return view('admin.class_examination_discount.create', [
            'announcements' => $announcements,
        ]);
    }

    /**
     * 存储新考试优惠
     * @param StoreClassExaminationDiscount $request
     * @param ClassExaminationDiscount $class_examination_discount
     * @return JsonResponse
     */
    public function store(StoreClassExaminationDiscount $request, ClassExaminationDiscount $class_examination_discount)
    {
        $class_examination_discount->name = strval($request->input('name'));
        $class_examination_discount->announcement_id = intval($request->input('announcement_id'));
        $class_examination_discount->remark = strval($request->input('remark'));
        $class_examination_discount->status = intval($request->input('status'));
        $class_examination_discount->user_id = $this->user()->getAuthIdentifier();

        return $this->returnOperationResponse($class_examination_discount->save(), $request);
    }

    /**
     * 编辑考试优惠
     * @param $id
     * @param Request $request
     * @param ClassExaminationDiscount $class_examination_discount
     * @param ClassAnnouncement $announcement
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id, Request $request, ClassExaminationDiscount $class_examination_discount, ClassAnnouncement $announcement)
    {
        $class_examination_discount = $class_examination_discount->newQuery()->find($id);
        $announcements = $announcement->allUsableWithOne($class_examination_discount->announcement_id);

        return view('admin.class_examination_discount.edit', [
            'class_examination_discount' => $class_examination_discount,
            'announcements' => $announcements,
        ]);
    }

    /**
     * 更新考试优惠
     * @param UpdateClassExaminationDiscount $request
     * @param ClassExaminationDiscount $class_examination_discount
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function update(UpdateClassExaminationDiscount $request, ClassExaminationDiscount $class_examination_discount)
    {
        try {
            $class_examination_discount = $class_examination_discount->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $class_examination_discount->name = strval($request->input('name'));
        $class_examination_discount->announcement_id = intval($request->input('announcement_id'));
        $class_examination_discount->remark = strval($request->input('remark'));
        $class_examination_discount->status = intval($request->input('status'));
        $class_examination_discount->user_id = $this->user()->getAuthIdentifier();

        return $this->returnOperationResponse($class_examination_discount->save(), $request);
    }

    /**
     * 删除考试优惠
     * @param Request $request
     * @param ClassExaminationDiscount $class_examination_discount
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function delete(Request $request, ClassExaminationDiscount $class_examination_discount)
    {
        try {
            $class_examination_discount = $class_examination_discount->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }
        return $this->returnOperationResponse($class_examination_discount->delete(), $request);
    }
}
