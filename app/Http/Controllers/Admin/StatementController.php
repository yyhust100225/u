<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DataNotExistsException;
use App\Http\Requests\StoreStatement;
use App\Http\Requests\UpdateStatement;
use App\Models\Department;
use App\Models\Exam;
use App\Models\ExamCategory;
use App\Models\Maps\MapStatementToExamCategories;
use App\Models\Maps\MapStatementToExams;
use App\Models\PrintedMatter;
use App\Models\Printer;
use App\Models\Statement;
use App\Http\Resources\StatementResource;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

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

        $statements = $statement->selectData($request->input('page'), $request->input('limit'), $where);

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

    /**
     * 存储新账单
     * @param StoreStatement $request
     * @param Statement $statement
     * @param MapStatementToExams $mste
     * @param MapStatementToExamCategories $mstec
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(StoreStatement $request, Statement $statement, MapStatementToExams $mste, MapStatementToExamCategories $mstec)
    {
        $statement->printer_id = intval($request->input('printer_id'));
        $statement->publisher_id = intval($request->user()->getAuthIdentifier());
        $statement->publish_date = $request->input('publish_date');
        $statement->department_id = intval($request->input('department_id'));
        $statement->printed_matter_id = intval($request->input('printed_matter_id'));
        $statement->print_detail = strval($request->input('print_detail'));
        $statement->quantity_print = intval($request->input('quantity_print'));
        $statement->price_print = floatval($request->input('price_print'));
        $statement->designer_quote_price = floatval($request->input('designer_quote_price'));
        $statement->applicant = $request->user()->getAttribute('username');
        $statement->status = STATEMENT_NOT_VERIFIED;
        $statement->remark = strval($request->input('remark'));

        $exam_categories = array_keys($request->input('exam_categories'));
        $exams = array_map('string_to_integer', explode(',', $request->input('exams')));

        $ret = true;
        DB::transaction(function() use($request, $statement, $mste, $mstec, $exams, $exam_categories, &$ret){
            if(!$statement->save()) $ret = false;
            if(!$mste->saveStatementToExams($statement->id, $exams)) $ret = false;
            if(!$mstec->saveStatementToExamCategories($statement->id, $exam_categories)) $ret = false;
        });

        return $this->returnOperationResponse($ret, $request);
    }

    /**
     * 编辑账单
     * @param $id
     * @param Request $request
     * @param Statement $statement
     * @param Printer $printer
     * @param ExamCategory $exam_category
     * @param Exam $exam
     * @param Department $department
     * @param PrintedMatter $printed_matter
     * @return Application|Factory|View
     */
    public function edit($id, Request $request, Statement $statement, Printer $printer, ExamCategory $exam_category, Exam $exam, Department $department, PrintedMatter $printed_matter)
    {
        $statement = $statement->newQuery()->find($id);
        $statement->exam_categories = $statement->exam_categories->map(function($exam_category){
            return $exam_category->id;
        })->toArray();
        $statement->exams = $statement->exams->map(function($exam){
            return $exam->id;
        })->toArray();

        $printers = $printer->newQuery()->get();
        $exam_categories = $exam_category->newQuery()->get();
        $exams = $exam->newQuery()->get();
        $departments = $department->newQuery()->get();
        $printed_matters = $printed_matter->newQuery()->get();

        return view('admin.statement.edit', [
            'statement' => $statement,
            'printers' => $printers,
            'exam_categories' => $exam_categories,
            'exams' => $exams,
            'departments' => $departments,
            'printed_matters' => $printed_matters,
        ]);
    }

    /**
     * 更新账单
     * @param UpdateStatement $request
     * @param Statement $statement
     * @param MapStatementToExams $mste
     * @param MapStatementToExamCategories $mstec
     * @return JsonResponse
     * @throws Throwable
     */
    public function update(UpdateStatement $request, Statement $statement, MapStatementToExams $mste, MapStatementToExamCategories $mstec)
    {
        $statement = $statement->find($request->input('id'));
        $statement->printer_id = intval($request->input('printer_id'));
        $statement->publisher_id = intval($request->user()->getAuthIdentifier());
        $statement->publish_date = $request->input('publish_date');
        $statement->department_id = intval($request->input('department_id'));
        $statement->printed_matter_id = intval($request->input('printed_matter_id'));
        $statement->print_detail = strval($request->input('print_detail'));
        $statement->quantity_print = intval($request->input('quantity_print'));
        $statement->price_print = floatval($request->input('price_print'));
        $statement->designer_quote_price = floatval($request->input('designer_quote_price'));
        $statement->applicant = $request->user()->getAttribute('username');
        $statement->status = $statement->designer_quote_price == $statement->printer_quote_price ? STATEMENT_VALIDATION_SUCCESSFUL : STATEMENT_VALIDATION_FAILED;
        $statement->remark = strval($request->input('remark'));

        $exam_categories = array_keys($request->input('exam_categories'));
        $exams = array_map('string_to_integer', explode(',', $request->input('exams')));

        $ret = true;
        DB::transaction(function () use ($request, $statement, $mste, $mstec, $exams, $exam_categories, &$ret) {
            if (!$statement->save()) $ret = false;
            if (!$mste->saveStatementToExams($statement->id, $exams)) $ret = false;
            if (!$mstec->saveStatementToExamCategories($statement->id, $exam_categories)) $ret = false;
        });

        return $this->returnOperationResponse($ret, $request);
    }

    /**
     * 删除账单
     * @param Request $request
     * @param Statement $statement
     * @param MapStatementToExams $mste
     * @param MapStatementToExamCategories $mstec
     * @return JsonResponse
     * @throws DataNotExistsException
     * @throws Throwable
     */
    public function delete(Request $request, Statement $statement, MapStatementToExams $mste, MapStatementToExamCategories $mstec)
    {
        try {
            $statement = $statement->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $ret = true;
        DB::transaction(function() use($statement, $mste, $mstec, &$ret){
            if(
                $mste->newQuery()->where('statement_id', $statement->id)->delete() === false ||
                $mstec->newQuery()->where('statement_id', $statement->id)->delete() === false ||
                $statement->delete() === false
            ) $ret = false;
        });

        return $this->returnOperationResponse($ret, $request);
    }
}
