<?php

namespace App\Models\Maps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Common;

/**
 * App\Models\Maps\MapSubjectToTeachers
 *
 * @property int $id
 * @property int $subject_id 科目ID
 * @property int $teacher_id 教师ID
 * @method static \Illuminate\Database\Eloquent\Builder|MapSubjectToTeachers newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MapSubjectToTeachers newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MapSubjectToTeachers query()
 * @method static \Illuminate\Database\Eloquent\Builder|MapSubjectToTeachers whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MapSubjectToTeachers whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MapSubjectToTeachers whereTeacherId($value)
 * @mixin \Eloquent
 */
class MapSubjectToTeachers extends Common
{
    use HasFactory;
}
