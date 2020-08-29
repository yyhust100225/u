<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Common extends Model
{
    /**
     * 查询分页数据
     * @param $page integer 当前查询页码
     * @param $limit integer 每页数据量
     * @return mixed 查询到数据
     */
    public function data($page, $limit)
    {
        return $this->offset(($page - 1) * $limit)->limit($limit)->get();
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
