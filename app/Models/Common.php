<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\Common
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Common newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Common newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Common query()
 * @mixin \Eloquent
 */
class Common extends Model
{
    protected $table;

    /**
     * 查询分页数据
     * @param integer $page 查询页
     * @param integer $limit 每页数据量
     * @param array $where 查询条件
     * @param array|string $with 关联查询
     * @return mixed 查询数据
     */
    public function select($page, $limit, $where = array(), $with = '')
    {
        $model = $this->newQuery();

        foreach($where as $field => $value) {
            if(is_array($value))
                $model->where($field, $value[0], $value[1]);
            else
                $model->where($field, $value);
        }

        $return['count'] = $model->count();

        if($with == '')
            $return['data'] = $model->offset(($page - 1) * $limit)->limit($limit)->get();
        else
            $return['data'] = $model->with($with)->offset(($page - 1) * $limit)->limit($limit)->get();

        return $return;
    }

    /**
     * 查询数据总量
     * @return mixed
     */
    public function num($where = array())
    {
        $model = $this->newQuery();

        foreach($where as $field => $value) {
            if(is_array($value))
                $model->where($field, $value[0], $value[1]);
            else
                $model->where($field, $value);
        }

        return $model->count();
    }
}
