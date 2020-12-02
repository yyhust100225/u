<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\CourseFee
 *
 * @property int $id
 * @property string $name 名称
 * @property string $fee 费用
 * @method static \Illuminate\Database\Eloquent\Builder|CourseFee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CourseFee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CourseFee query()
 * @method static \Illuminate\Database\Eloquent\Builder|CourseFee whereFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseFee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseFee whereName($value)
 * @mixin \Eloquent
 */
class CourseFee extends Common
{
    use HasFactory;
}
