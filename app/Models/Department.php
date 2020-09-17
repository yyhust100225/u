<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Common
{
    // 上级部门关联
    public function parent_department()
    {
        return $this->hasOne(Department::class, 'id', 'p_id');
    }
}
