<?php

namespace App\Models;

use App\Models\Maps\MapSubjectToTeachers;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Subject
 *
 * @property int $id
 * @property string $name 科目名称
 * @property string $remark 备注
 * @property int $user_id 录入人
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Subject newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subject newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subject query()
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereUserId($value)
 * @mixin \Eloquent
 */
class Subject extends Common
{
    use HasFactory;

    // 关联科目讲师
    public function teachers(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(Teacher::class, MapSubjectToTeachers::class, 'subject_id', 'id', 'id', 'teacher_id');
    }
}
