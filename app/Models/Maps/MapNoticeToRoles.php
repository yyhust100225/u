<?php

namespace App\Models\Maps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Common;

/**
 * App\Models\Maps\MapNoticeToRoles
 *
 * @property int $id
 * @property int $notice_id 要讯ID
 * @property int $role_id 角色ID
 * @method static \Illuminate\Database\Eloquent\Builder|MapNoticeToRoles newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MapNoticeToRoles newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MapNoticeToRoles query()
 * @method static \Illuminate\Database\Eloquent\Builder|MapNoticeToRoles whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MapNoticeToRoles whereNoticeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MapNoticeToRoles whereRoleId($value)
 * @mixin \Eloquent
 */
class MapNoticeToRoles extends Common
{
    use HasFactory;

    // 删除指定要讯抄送角色映射
    public function deleteMaps($notice_id)
    {
        return $this->where('notice_id', $notice_id)->delete();
    }
}
