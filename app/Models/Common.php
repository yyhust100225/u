<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Common extends Model
{
    protected $table;

    /**
     * 查询分页数据
     * @param $page integer 当前查询页码
     * @param $limit integer 每页数据量
     * @param $with array|string 关联查询
     * @return mixed 查询到数据
     */
    public function data($page, $limit, $with = '')
    {
        if($with == '')
            return $this->offset(($page - 1) * $limit)->limit($limit)->get();
        else
            return $this->with($with)->offset(($page - 1) * $limit)->limit($limit)->get();
    }

    /**
     * 查询数据总量
     * @return mixed
     */
    public function num()
    {
        return $this->count();
    }
}
