<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->hasMany(ClassCourseDate::class, 'class_course_id');
    }
}
