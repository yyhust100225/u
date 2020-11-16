<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ClassCourseType
 *
 * @property int $id
 * @property string $name 开课类型名称
 * @method static \Illuminate\Database\Eloquent\Builder|ClassCourseType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassCourseType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassCourseType query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassCourseType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassCourseType whereName($value)
 * @mixin \Eloquent
 */
class ClassCourseType extends Common
{
    use HasFactory;

    public $timestamps = false;
}
