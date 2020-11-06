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
use Illuminate\Support\Facades\Auth;
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
        $class_announcement->title = strval($request->input('title'));
        $class_announcement->city_id = intval($request->input('city_id'));
        $class_announcement->announcement_type = intval($request->input('announcement_type'));
        $class_announcement->level = strval($request->input('level'));
        $class_announcement->publish_date = $request->input('publish_date');
        $class_announcement->candidate_num = intval($request->input('candidate_num'));
        $class_announcement->enroll_date_start = $request->input('enroll_date_start');
        $class_announcement->enroll_date_end = $request->input('enroll_date_end');
        $class_announcement->enroll_type = intval($request->input('enroll_type'));
        $class_announcement->exam_type = intval($request->input('exam_type'));
        $class_announcement->written_exam_activity_num = intval($request->input('written_exam_activity_num'));
        $class_announcement->written_exam_date = $request->input('written_exam_date');
        $class_announcement->written_exam_class_open = intval($request->input('written_exam_class_open'));
        $class_announcement->written_exam_take_problem_sets = intval($request->input('written_exam_take_problem_sets'));
        $class_announcement->written_exam_in_examination_num = intval($request->input('written_exam_in_examination_num'));
        $class_announcement->check_qualification_date = $request->input('check_qualification_date');
        $class_announcement->interview_activity_num = intval($request->input('interview_activity_num'));
        $class_announcement->interview_date = $request->input('interview_date');
        $class_announcement->interview_class_open = intval($request->input('interview_class_open'));
        $class_announcement->interview_take_problem_sets = intval($request->input('interview_take_problem_sets'));
        $class_announcement->pass_percent = floatval($request->input('pass_percent'));
        $class_announcement->status = intval($request->input('status'));
        $class_announcement->user_id = $this->user()->getAuthIdentifier();

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
