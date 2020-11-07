<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ClassExaminationDiscountType
 *
 * @property int $id
 * @property int $pid 优惠类型父ID
 * @property string $name 类型名称
 * @method static \Illuminate\Database\Eloquent\Builder|ClassExaminationDiscountType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassExaminationDiscountType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassExaminationDiscountType query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassExaminationDiscountType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassExaminationDiscountType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassExaminationDiscountType wherePid($value)
 * @mixin \Eloquent
 */
class ClassExaminationDiscountType extends Common
{
    use HasFactory;
    public $timestamps = false;
}
