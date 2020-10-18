<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DataNotExistsException;
use App\Http\Requests\StoreBookSale;
use App\Http\Requests\UpdateBookSale;
use App\Http\Resources\BookSaleResource;
use App\Models\BookBuyer;
use App\Models\BookSale;
use App\Models\Department;
use App\Models\PaymentMethod;
use App\Models\User;
use App\Models\Book;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;
use function Symfony\Component\String\u;

class BookSaleController extends ProjectDepartmentController
{
    public function __construct(Request $request)
    {
        $action = $request->route()->getActionMethod();
        $this->middleware('can:' . $action . ',' . BookSale::class);
        parent::__construct($request);
    }

    /**
     * 书籍销售记录列表页
     * @param Request $request
     * @param BookSale $book_sale
     * @return Application|Factory|View
     */
    public function list(Request $request, BookSale $book_sale)
    {
        return view('admin.book_sale.list');
    }

    /**
     * 书籍销售记录列表数据
     * @param Request $request
     * @param BookSale $book_sale
     * @return JsonResponse
     */
    public function data(Request $request, BookSale $book_sale)
    {
        $where = array();
        if($request->has('action') && $request->input('action') == 'search'){
            parse_str($request->input('where'), $con);

            // 搜索条件
            if(!empty($con['name']))
                $where['name'] = ['like', '%'.$con['name'].'%'];
        }

        $book_sales = $book_sale->selectData($request->input('page'), $request->input('limit'), $where);

        return response()->json([
            'code' => RESPONSE_SUCCESS,
            'msg' => trans('request.success'),
            'count' => $book_sales['count'],
            'data' => BookSaleResource::collection($book_sales['data']),
        ], 200);
    }

    /**
     * 创建书籍销售记录
     * @param Request $request
     * @param Book $book
     * @param Department $department
     * @param User $user
     * @param PaymentMethod $payment_method
     * @return Application|Factory|View
     */
    public function create(Request $request, Book $book, Department $department, User $user, PaymentMethod $payment_method)
    {
        $books = $book->all();
        $departments = $department->all();
        $users = $user->all();
        $payment_methods = $payment_method->all();

        return view('admin.book_sale.create', [
            'books' => $books,
            'departments' => $departments,
            'users' => $users,
            'payment_methods' => $payment_methods,
        ]);
    }

    /**
     * 存储新书籍销售记录
     * @param StoreBookSale $request
     * @param BookSale $book_sale
     * @param BookBuyer $book_buyer
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(StoreBookSale $request, BookSale $book_sale, BookBuyer $book_buyer)
    {
        $book_sale->book_id = intval($request->input('book_id'));
        $book_sale->department_id = intval($request->input('department_id'));
        $book_sale->user_id = intval($request->input('user_id'));
        $book_sale->remark = strval($request->input('remark'));

        $names = $request->input('name');
        if(empty($names)) {
            $this->returnFailedResponse(trans('request.write one record'));
        }

        $book_sale->total_quantity = array_sum($request->input('quantity'));
        $book_sale->total_cost = array_sum($request->input('cost'));

        $buyers = [];
        foreach ($names as $key => $name) {
            $buyers[$key]['name'] = strval($name);
            $buyers[$key]['gender'] = $request->input('gender')[$key];
            $buyers[$key]['id_number'] = strval($request->input('id_number')[$key]);
            $buyers[$key]['tel'] = strval($request->input('tel')[$key]);
            $buyers[$key]['quantity'] = intval($request->input('quantity')[$key]);
            $buyers[$key]['payment_method'] = $request->input('payment_method')[$key];
            $buyers[$key]['cost'] = floatval($request->input('cost')[$key]);
        }

        $ret = true;
        DB::transaction(function() use($request, $book_sale, $book_buyer, $buyers, &$ret){
            if(!$book_sale->save()) $ret = false;
            if(!$book_buyer->saveBookBuyers($book_sale->id, $buyers)) $ret = false;
        });

        return $this->returnOperationResponse($ret, $request);
    }

    /**
     * 编辑书籍销售记录
     * @param $id
     * @param Request $request
     * @param BookSale $book_sale
     * @param Book $book
     * @param Department $department
     * @param User $user
     * @param PaymentMethod $payment_method
     * @return Application|Factory|View
     */
    public function edit($id, Request $request, BookSale $book_sale, Book $book, Department $department, User $user, PaymentMethod $payment_method)
    {
        $book_sale = $book_sale->newQuery()->find($id);
        $buyers = $book_sale->buyers;

        $books = $book->all();
        $departments = $department->all();
        $users = $user->all();
        $payment_methods = $payment_method->all();

        return view('admin.book_sale.edit', [
            'book_sale' => $book_sale,
            'books' => $books,
            'departments' => $departments,
            'users' => $users,
            'buyers' => $buyers,
            'payment_methods' => $payment_methods,
        ]);
    }

    /**
     * 更新书籍销售记录
     * @param UpdateBookSale $request
     * @param BookSale $book_sale
     * @param BookBuyer $book_buyer
     * @return JsonResponse
     * @throws DataNotExistsException|Throwable
     */
    public function update(UpdateBookSale $request, BookSale $book_sale, BookBuyer $book_buyer)
    {
        try {
            $book_sale = $book_sale->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $book_sale->book_id = intval($request->input('book_id'));
        $book_sale->department_id = intval($request->input('department_id'));
        $book_sale->user_id = intval($request->input('user_id'));
        $book_sale->remark = strval($request->input('remark'));

        $names = $request->input('name');
        if(empty($names)) {
            $this->returnFailedResponse(trans('request.write one record'));
        }

        $book_sale->total_quantity = array_sum($request->input('quantity'));
        $book_sale->total_cost = array_sum($request->input('cost'));

        $buyers = [];
        foreach ($names as $key => $name) {
            $buyers[$key]['name'] = strval($name);
            $buyers[$key]['gender'] = $request->input('gender')[$key];
            $buyers[$key]['id_number'] = strval($request->input('id_number')[$key]);
            $buyers[$key]['tel'] = strval($request->input('tel')[$key]);
            $buyers[$key]['quantity'] = intval($request->input('quantity')[$key]);
            $buyers[$key]['payment_method'] = $request->input('payment_method')[$key];
            $buyers[$key]['cost'] = floatval($request->input('cost')[$key]);
        }

        $ret = true;
        DB::transaction(function() use($request, $book_sale, $book_buyer, $buyers, &$ret){
            if(!$book_sale->save()) $ret = false;
            if(!$book_buyer->saveBookBuyers($book_sale->id, $buyers)) $ret = false;
        });

        return $this->returnOperationResponse($ret, $request);
    }

    /**
     * 删除书籍销售记录
     * @param Request $request
     * @param BookSale $book_sale
     * @param BookBuyer $book_buyer
     * @return JsonResponse
     * @throws DataNotExistsException
     * @throws Throwable
     */
    public function delete(Request $request, BookSale $book_sale, BookBuyer $book_buyer)
    {
        try {
            $book_sale = $book_sale->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $ret = true;
        DB::transaction(function() use($request, $book_sale, $book_buyer, &$ret){
            if(!$book_sale->delete()) $ret = false;
            if(!$book_buyer->deleteBookBuyers($book_sale->id)) $ret = false;
        });

        return $this->returnOperationResponse($ret, $request);
    }
}
