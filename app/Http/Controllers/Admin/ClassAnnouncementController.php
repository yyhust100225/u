<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DataNotExistsException;
use App\Http\Requests\StoreClassAnnouncement;
use App\Http\Requests\UpdateClassAnnouncement;
use App\Http\Resources\ClassAnnouncementResource;
use App\Models\AnnouncementType;
use App\Models\City;
use App\Models\ClassAnnouncement;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClassAnnouncementController extends ProjectDepartmentController
{
    public function __construct(Request $request)
    {
        $action = $request->route()->getActionMethod();
        $this->middleware('can:' . $action . ',' . ClassAnnouncement::class);
        parent::__construct($request);
    }

    /**
     * 开班公告列表页
     * @param Request $request
     * @param ClassAnnouncement $class_announcement
     * @return Application|Factory|View
     */
    public function list(Request $request, ClassAnnouncement $class_announcement)
    {
        return view('admin.class_announcement.list');
    }

    /**
     * 开班公告列表数据
     * @param Request $request
     * @param ClassAnnouncement $class_announcement
     * @return JsonResponse
     */
    public function data(Request $request, ClassAnnouncement $class_announcement)
    {
        $where = array();
        if($request->has('action') && $request->input('action') == 'search'){
            parse_str($request->input('where'), $con);

            // 搜索条件
            if(!empty($con['name']))
                $where['name'] = ['like', '%'.$con['name'].'%'];
        }

        $class_announcements = $class_announcement->selectData($request->input('page'), $request->input('limit'), $where);

        return response()->json([
            'code' => RESPONSE_SUCCESS,
            'msg' => trans('request.success'),
            'count' => $class_announcements['count'],
            'data' => ClassAnnouncementResource::collection($class_announcements['data']),
        ], 200);
    }

    /**
     * 创建新开班公告
     * @param Request $request
     * @return Application|Factory|View
     */
    public function create(Request $request, City $city, AnnouncementType $announcement_type)
    {
        $cities = $city->all();
        $announcement_types = $announcement_type->all();

        return view('admin.class_announcement.create', [
            'cities' => $cities,
            'announcement_types' => $announcement_types,
        ]);
    }

    /**
     * 存储新开班公告
     * @param StoreClassAnnouncement $request
     * @param ClassAnnouncement $class_announcement
     * @return JsonResponse
     */
    public function store(StoreClassAnnouncement $request, ClassAnnouncement $class_announcement)
    {
        $class_announcement->title = $request->input('title');

        return $this->returnOperationResponse($class_announcement->save(), $request);
    }

    /**
     * 编辑开班公告
     * @param $id
     * @param Request $request
     * @param ClassAnnouncement $class_announcement
     * @return Application|Factory|View
     */
    public function edit($id, Request $request, ClassAnnouncement $class_announcement)
    {
        $class_announcement = $class_announcement->newQuery()->find($id);

        return view('admin.class_announcement.edit', [
            'class_announcement' => $class_announcement,
        ]);
    }

    /**
     * 更新开班公告
     * @param UpdateClassAnnouncement $request
     * @param ClassAnnouncement $class_announcement
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function update(UpdateClassAnnouncement $request, ClassAnnouncement $class_announcement)
    {
        try {
            $class_announcement = $class_announcement->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $class_announcement->name = strval($request->input('name'));

        return $this->returnOperationResponse($class_announcement->save(), $request);
    }

    /**
     * 删除开班公告
     * @param Request $request
     * @param ClassAnnouncement $class_announcement
     * @return JsonResponse
     * @throws DataNotExistsException
     */
    public function delete(Request $request, ClassAnnouncement $class_announcement)
    {
        try {
            $class_announcement = $class_announcement->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }
        return $this->returnOperationResponse($class_announcement->delete(), $request);
    }
}
