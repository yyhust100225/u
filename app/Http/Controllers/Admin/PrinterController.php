<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DataNotExistsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePrinter;
use App\Http\Requests\UpdatePrinter;
use App\Http\Resources\PrinterResource;
use App\Models\Printer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PrinterController extends ProjectDepartmentController
{
    public function __construct(Request $request)
    {
        $action = $request->route()->getActionMethod();
        $this->middleware('can:' . $action . ',' . Printer::class);
        parent::__construct($request);
    }

    /**
     * 印刷厂列表页
     * @param Request $request
     * @param Printer $printer
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(Request $request, Printer $printer)
    {
        return view('admin.printer.printers');
    }

    /**
     * 印刷厂列表数据
     * @param Request $request
     * @param Printer $printer
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request, Printer $printer)
    {
        $where = array();
        if($request->has('action') && $request->input('action') == 'search'){
            parse_str($request->input('where'), $con);

            // 搜索条件
            if(!empty($con['name']))
                $where['name'] = ['like', '%'.$con['name'].'%'];
        }

        $printers = $printer->select($request->input('page'), $request->input('limit'), $where);

        return response()->json([
            'code' => RESPONSE_SUCCESS,
            'msg' => trans('request.success'),
            'count' => $printers['count'],
            'data' => PrinterResource::collection($printers['data']),
        ], 200);
    }

    /**
     * 创建新印刷厂
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {

        return view('admin.printer.create');
    }

    /**
     * 存储新印刷厂
     * @param StorePrinter $request
     * @param Printer $printer
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePrinter $request, Printer $printer)
    {
        $printer->name = $request->input('name');
        $printer->tel = strval($request->input('tel'));
        $printer->account = strval($request->input('account'));
        $printer->remark = strval($request->input('remark'));

        return $this->returnOperationResponse($printer->save(), $request);
    }

    /**
     * 编辑印刷厂
     * @param $id
     * @param Request $request
     * @param Printer $printer
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, Request $request, Printer $printer)
    {
        $printer = $printer->newQuery()->find($id);

        return view('admin.printer.edit', [
            'printer' => $printer,
        ]);
    }

    /**
     * 更新印刷厂
     * @param UpdatePrinter $request
     * @param Printer $printer
     * @return \Illuminate\Http\JsonResponse
     * @throws DataNotExistsException
     */
    public function update(UpdatePrinter $request, Printer $printer)
    {
        try {
            $printer = $printer->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $printer->name = strval($request->input('name'));
        $printer->tel = strval($request->input('tel'));
        $printer->account = strval($request->input('account'));
        $printer->remark = strval($request->input('remark'));

        return $this->returnOperationResponse($printer->save(), $request);
    }

    /**
     * 删除印刷厂
     * @param Request $request
     * @param Printer $printer
     * @return \Illuminate\Http\JsonResponse
     * @throws DataNotExistsException
     */
    public function delete(Request $request, Printer $printer)
    {
        try {
            $printer = $printer->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }
        return $this->returnOperationResponse($printer->delete(), $request);
    }
}
