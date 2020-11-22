<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ClassCourse
 *
 * @property int $id
 * @property string $name 考试名称
 * @property int $class_type_id 所属班型ID
 * @property int $class_course_type_id 开课类型ID
 * @property int $department_id 开课校区ID
 * @property string $address 开课具体地址
 * @property int $day_num 开课天数
 * @property int $max_person_num 封班人数
 * @property int $in_hotel 是否住店 0否 1是
 * @property string|null $in_hotel_date 学生住店日期
 * @property string $remark 备注
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ClassCourseDate[] $class_course_dates
 * @property-read int|null $class_course_dates_count
 * @property-read \App\Models\ClassCourseType $class_course_type
 * @property-read \App\Models\ClassType $class_type
 * @method static \Illuminate\Database\Eloquent\Builder|ClassCourse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassCourse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassCourse query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassCourse whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassCourse whereClassCourseTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassCourse whereClassTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassCourse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassCourse whereDayNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassCourse whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassCourse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassCourse whereInHotel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassCourse whereInHotelDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassCourse whereMaxPersonNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassCourse whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassCourse whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassCourse whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Department $department
 */
class ClassCourse extends Common
{
    use HasFactory;

    // 关联班型表
    public function class_type()
    {
        return $this->belongsTo(ClassType::class, 'class_type_id');
    }

    // 关联课程类型表
    public function class_course_type()
    {
        return $this->belongsTo(ClassCourseType::class, 'class_course_type_id');
    }

    // 关联课程日期
    public function class_course_dates()
    {
        return $this->hasMany(ClassCourseDate::class, 'class_course_id')->pluck('class_course_date');
    }

    // 关联开课校区
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
