<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DataNotExistsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\OptBook;
use App\Http\Requests\StoreBook;
use App\Http\Requests\UpdateBook;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Http\Resources\BookResource;
use App\Models\Department;

class BookController extends ProjectDepartmentController
{
    public function __construct(Request $request)
    {
        $action = $request->route()->getActionMethod();
        $this->middleware('can:' . $action . ',' . Book::class);
        parent::__construct($request);
    }

    /**
     * 书籍物料列表页
     * @param Request $request
     * @param Book $book
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(Request $request, Book $book)
    {
        return view('admin.book.books');
    }

    /**
     * 书籍物料列表数据
     * @param Request $request
     * @param Book $book
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request, Book $book)
    {
        $where = array();
        if($request->has('action') && $request->input('action') == 'search'){
            parse_str($request->input('where'), $con);

            // 搜索条件
            if(!empty($con['name']))
                $where['name'] = ['like', '%'.$con['name'].'%'];
        }

        $books = $book->select($request->input('page'), $request->input('limit'), $where);

        return response()->json([
            'code' => RESPONSE_SUCCESS,
            'msg' => trans('request.success'),
            'count' => $books['count'],
            'data' => BookResource::collection($books['data']),
        ], 200);
    }

    /**
     * 创建新书籍物料
     * @param Request $request
     * @param Department $department
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request, Department $department)
    {
        $departments = $department->all();
        return view('admin.book.create', [
            'departments' => $departments,
        ]);
    }

    /**
     * 存储书籍物料
     * @param StoreBook $request
     * @param Book $book
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreBook $request, Book $book)
    {
        $book->name = $request->input('name');
        $book->department_id = $request->input('department_id');
        $book->quantity_total = $request->input('quantity_total');
        $book->quantity_sold = $request->input('quantity_sold');
        $book->quantity_give = $request->input('quantity_give');
        $book->quantity_return = $request->input('quantity_return');
        $book->quantity_usable = $request->input('quantity_total') - $request->input('quantity_sold') - $request->input('quantity_give') - $request->input('quantity_return');

        return $this->returnOperationResponse($book->save(), $request);
    }

    /**
     * 编辑书籍物料
     * @param $id
     * @param Request $request
     * @param Book $book
     * @param Department $department
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, Request $request, Book $book, Department $department)
    {
        $book = $book->newQuery()->find($id);
        $departments = $department->all();
        return view('admin.book.edit', [
            'book' => $book,
            'departments' => $departments,
        ]);
    }

    /**
     * 更新书籍物料
     * @param UpdateBook $request
     * @param Book $book
     * @return \Illuminate\Http\JsonResponse
     * @throws DataNotExistsException
     */
    public function update(UpdateBook $request, Book $book)
    {
        try {
            $book = $book->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $book->name = $request->input('name');
        $book->department_id = $request->input('department_id');
        $book->quantity_total = $request->input('quantity_total');
        $book->quantity_sold = $request->input('quantity_sold');
        $book->quantity_give = $request->input('quantity_give');
        $book->quantity_return = $request->input('quantity_return');
        $book->quantity_usable = $request->input('quantity_total') - $request->input('quantity_sold') - $request->input('quantity_give') - $request->input('quantity_return');

        return $this->returnOperationResponse($book->save(), $request);
    }

    /**
     * 删除书籍物料
     * @param Request $request
     * @param Book $book
     * @return \Illuminate\Http\JsonResponse
     * @throws DataNotExistsException
     */
    public function delete(Request $request, Book $book)
    {
        try {
            $book = $book->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }
        return $this->returnOperationResponse($book->delete(), $request);
    }

    /**
     * 增加书籍数量
     * @param $id
     * @param Request $request
     * @param Book $book
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function increase($id, Request $request, Book $book)
    {
        $book = $book->newQuery()->find($id);
        return view('admin.book.increase', [
            'book' => $book,
        ]);
    }

    /**
     * 补充书籍数量
     * @param OptBook $request
     * @param Book $book
     * @return \Illuminate\Http\JsonResponse
     * @throws DataNotExistsException
     */
    public function supplement(OptBook $request, Book $book)
    {
        try {
            $book = $book->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $book->quantity_total = $book->quantity_total + $request->input('quantity_supplement');
        $book->quantity_usable = $book->quantity_usable + $request->input('quantity_supplement');

        return $this->returnOperationResponse($book->save(), $request);
    }

    /**
     * 减少书籍数量
     * @param $id
     * @param Request $request
     * @param Book $book
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function decrease($id, Request $request, Book $book)
    {
        $book = $book->newQuery()->find($id);
        return view('admin.book.decrease', [
            'book' => $book,
        ]);
    }

    /**
     * 消耗书籍数量
     * @param OptBook $request
     * @param Book $book
     * @return \Illuminate\Http\JsonResponse
     * @throws DataNotExistsException
     */
    public function consume(OptBook $request, Book $book)
    {
        try {
            $book = $book->newQuery()->find($request->input('id'));
        } catch(ModelNotFoundException $exception) {
            throw new DataNotExistsException(trans('request.failed'), REQUEST_FAILED);
        }

        $book->quantity_sold = $book->quantity_sold + $request->input('quantity_sold');
        $book->quantity_give = $book->quantity_give + $request->input('quantity_give');
        $book->quantity_return = $book->quantity_return + $request->input('quantity_return');
        $book->quantity_usable = $book->quantity_usable - $request->input('quantity_sold') - $request->input('quantity_give') - $request->input('quantity_return');

        return $this->returnOperationResponse($book->save(), $request);
    }
}
