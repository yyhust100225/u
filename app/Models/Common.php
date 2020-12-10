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
    public function selectData($page, $limit, $where = array(), $with = '')
    {
        $model = $this->newQuery();

        foreach($where as $field => $value) {

            // 组合或条件查询
            if($field === 'logic:or') {
                $model->orWhere(function($query) use($value){
                    foreach($value as $key => $item) {
                        $query->where($key, $item);
                    }
                });
            } else if(is_array($value)) {
                if($value[0] == 'in')
                    $model->whereIn($field, $value[1]);
                else if($value[0] == 'or:in')
                    $model->orWhereIn($field, $value[1]);
                else if($value[0] == 'or')
                    $model->orWhere($field, $value[1]);
                else
                    $model->where($field, $value[0], $value[1]);
            }
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

    // 获取所有可用资源
    public function allUsable()
    {
        return $this->where(['status' => STATUS_ON])->get();
    }

    // 获取所有可用资源及一条指定查询资源
    public function allUsableWithOne($con)
    {
        // 当条件为数字时 判定为主键ID
        if(is_numeric($con) && $con >= 1) {
            return $this->where(['status' => STATUS_ON])->orWhere(['id' => $con])->get();
        } else {
            return $this->where(['status' => STATUS_ON])->orWhere($con)->get();
        }
    }

    // 关联用户表
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 关联部门表
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
