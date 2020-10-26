<?php

namespace App\Models\Maps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Common;

/**
 * App\Models\Maps\MapNoticeToUsers
 *
 * @property int $id
 * @property int $notice_id 要讯ID
 * @property int $user_id 用户ID
 * @method static \Illuminate\Database\Eloquent\Builder|MapNoticeToUsers newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MapNoticeToUsers newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MapNoticeToUsers query()
 * @method static \Illuminate\Database\Eloquent\Builder|MapNoticeToUsers whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MapNoticeToUsers whereNoticeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MapNoticeToUsers whereUserId($value)
 * @mixin \Eloquent
 */
class MapNoticeToUsers extends Common
{
    use HasFactory;

    // 删除指定要讯抄送用户映射
    public function deleteMaps($notice_id)
    {
        return $this->where('notice_id', $notice_id)->delete();
    }
}
