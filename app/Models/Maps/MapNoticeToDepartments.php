<?php

namespace App\Models\Maps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Common;
use Illuminate\Support\Facades\Log;

/**
 * App\Models\Maps\MapNoticeToDepartments
 *
 * @property int $id
 * @property int $notice_id 要讯ID
 * @property int $department_id 部门ID
 * @method static \Illuminate\Database\Eloquent\Builder|MapNoticeToDepartments newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MapNoticeToDepartments newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MapNoticeToDepartments query()
 * @method static \Illuminate\Database\Eloquent\Builder|MapNoticeToDepartments whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MapNoticeToDepartments whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MapNoticeToDepartments whereNoticeId($value)
 * @mixin \Eloquent
 */
class MapNoticeToDepartments extends Common
{
    use HasFactory;

    // 删除指定要讯抄送部门映射
    public function deleteMaps($notice_id)
    {
        return $this->where('notice_id', $notice_id)->delete();
    }
}
