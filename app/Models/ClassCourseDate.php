<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ClassCourseDate
 *
 * @property int $id
 * @property int $class_course_id 班级ID
 * @property string $class_course_date 开课日期
 * @method static \Illuminate\Database\Eloquent\Builder|ClassCourseDate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassCourseDate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassCourseDate query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassCourseDate whereClassCourseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassCourseDate whereClassCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassCourseDate whereId($value)
 * @mixin \Eloquent
 */
class ClassCourseDate extends Common
{
    use HasFactory;

    public $timestamps = false;

    // 删除所有班级开课日期
    public function deleteFromId($id)
    {
        return $this->where('class_course_id', $id)->delete();
    }
}
