<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\TeacherGroup
 *
 * @property int $id
 * @property string $name 分组名称
 * @method static \Illuminate\Database\Eloquent\Builder|TeacherGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeacherGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeacherGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|TeacherGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeacherGroup whereName($value)
 * @mixin Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Teacher[] $teachers
 * @property-read int|null $teachers_count
 */
class TeacherGroup extends Common
{
    use HasFactory;

    // 关联分组讲师
    public function teachers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Teacher::class, 'teacher_group_id');
    }
}
