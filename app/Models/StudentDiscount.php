<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\StudentDiscount
 *
 * @property int $id
 * @property int $student_id 学员信息ID
 * @property int $discount_id 优惠ID
 * @property int $discount_type 优惠类型 1考试优惠 2班型优惠
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDiscount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDiscount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDiscount query()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDiscount whereDiscountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDiscount whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDiscount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDiscount whereStudentId($value)
 * @mixin \Eloquent
 */
class StudentDiscount extends Common
{
    use HasFactory;
    public $timestamps = false;
}
