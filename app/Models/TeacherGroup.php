<?php

namespace App\Models;

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
 * @mixin \Eloquent
 */
class TeacherGroup extends Common
{
    use HasFactory;
}
