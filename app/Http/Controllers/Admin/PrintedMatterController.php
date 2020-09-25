<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DataNotExistsException;
use App\Http\Requests\StorePrintedMatter;
use App\Http\Requests\UpdatePrintedMatter;
use App\Http\Resources\PrintedMatterResource;
use App\Models\PrintedMatter;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PrintedMatterController extends CommonController
{
    public function __construct(Request $request)
    {
        $action = $request->route()->getActionMethod();
        $this->middleware('can:' . $action . ',' . PrintedMatter::class);
        parent::__construct();
    }

    /**
     * 印刷品列表页
     * @param Request $request
     * @param PrintedMatter $printed_matter
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(Request $request, PrintedMatter $printed_matter)
    {
        return view('admin.printed_matter.printed_matters');
    }

    /**
     * 印刷品列表数据
     * @param Request $request
     * @param PrintedMatter $printed_matter
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request, PrintedMatter $printed_matter)
    {
        $where = array();
        if($request->has('action') && $request->input('action') == 'search'){
            parse_str($request->input('where'), $con);

            // 搜索条件
            if(!empty($con['name']))
                $where['name'] = ['like', '%'.$con['name'].'%'];
        }

        $printed_matters = $printed_matter->select($request->input('page'), $request->input('limit'), $where);

        return response()->json([
            'code' => RESPONSE_SUCCESS,
            'msg' => trans('request.success'),
            'count' => $printed_matters['count'],
            'data' => PrintedMatterResource::collection($printed_matters['data']),
        ], 200);
    }

    /**
     * 创建新印刷品
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {

        return view('admin.printed_matter.create');
    }

    /**
     * 存储新印刷品
     * @param StorePrintedMatter $request
     * @param PrintedMatter $printed_matter
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePrintedMatter $request, PrintedMatter $printed_matter)
    {
        $printed_matter->name = $request->input('name');

        return $this->returnOperationResponse($printed_matter->save(), $request);
    }

    /**
     * 编辑印刷品
     * @param $id
     * @param Request $request
     * @param PrintedMatter $printed_matter
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, Request $request, PrintedMatter $printed_matter)
    {
        $printed_matter = $printed_matter->newQuery()->find($id);

        return view('admin.printed_matter.edit', [
            'printed_matter' => $printed_matter,
        ]);
    }

    /**
     * 更新印刷品
     * @param UpdatePrintedMatter $request
     * @param PrintedMatter $printed_matter
     * @return \Illuminate\Http\JsonResponse
     * @throws DataNotExistsException
     */
    public function update(UpdatePrintedMatter $request, PrintedMatter $printed_matter)
    {
        try {
            $printed_matter = $printed_matter->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $printed_matter->name = strval($request->input('name'));

        return $this->returnOperationResponse($printed_matter->save(), $request);
    }

    /**
     * 删除印刷品
     * @param Request $request
     * @param PrintedMatter $printed_matter
     * @return \Illuminate\Http\JsonResponse
     * @throws DataNotExistsException
     */
    public function delete(Request $request, PrintedMatter $printed_matter)
    {
        try {
            $printed_matter = $printed_matter->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }
        return $this->returnOperationResponse($printed_matter->delete(), $request);
    }
}
