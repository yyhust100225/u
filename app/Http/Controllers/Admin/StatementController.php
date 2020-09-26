<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreStatement;
use App\Models\Department;
use App\Models\Exam;
use App\Models\ExamCategory;
use App\Models\PrintedMatter;
use App\Models\Printer;
use App\Models\Statement;
use App\Http\Resources\StatementResource;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StatementController extends ProjectDepartmentController
{
    public function __construct(Request $request)
    {
        $action = $request->route()->getActionMethod();
        $this->middleware('can:' . $action . ',' . Statement::class);
        parent::__construct($request);
    }

    /**
     * 对账单列表页
     * @return Application|Factory|View
     */
    public function list()
    {
        return view('admin.statement.statements');
    }

    /**
     * 查询对账单列表数据
     * @param Request $request
     * @param Statement $statement
     * @return JsonResponse
     */
    public function data(Request $request, Statement $statement)
    {
        $where = array();
        if($request->has('action') && $request->input('action') == 'search'){
            parse_str($request->input('where'), $con);

            // 搜索条件
        }

        $statements = $statement->select($request->input('page'), $request->input('limit'), $where);

        return response()->json([
            'code' => RESPONSE_SUCCESS,
            'msg' => trans('request.success'),
            'count' => $statements['count'],
            'data' => StatementResource::collection($statements['data']),
        ], 200);
    }

    /**
     * 创建新对账单
     * @param Printer $printer
     * @param ExamCategory $exam_category
     * @param Exam $exam
     * @param Department $department
     * @param PrintedMatter $printed_matter
     * @return Application|Factory|View
     */
    public function create(Printer $printer, ExamCategory $exam_category, Exam $exam, Department $department, PrintedMatter $printed_matter)
    {
        $printers = $printer->newQuery()->get();
        $exam_categories = $exam_category->newQuery()->get();
        $exams = $exam->newQuery()->get();
        $departments = $department->newQuery()->get();
        $printed_matters = $printed_matter->newQuery()->get();

        return view('admin.statement.create', [
            'printers' => $printers,
            'exam_categories' => $exam_categories,
            'exams' => $exams,
            'departments' => $departments,
            'printed_matters' => $printed_matters,
        ]);
    }

    public function store(StoreStatement $request, Statement $statement)
    {
        $statement->printer_id = intval($request->input('printer_id'));

    }
}
