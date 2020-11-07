<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ClassExaminationDiscount
 *
 * @property int $id
 * @property int $examination_id 所属考试ID
 * @property int $discount_type_id 优惠类型ID
 * @property string $amount 优惠金额
 * @property int $status 状态 0停用 1启用
 * @property int $user_id 创建人
 * @property string $remark 备注
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|ClassExaminationDiscount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassExaminationDiscount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassExaminationDiscount query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassExaminationDiscount whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassExaminationDiscount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassExaminationDiscount whereDiscountTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassExaminationDiscount whereExaminationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassExaminationDiscount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassExaminationDiscount whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassExaminationDiscount whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassExaminationDiscount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassExaminationDiscount whereUserId($value)
 * @mixin \Eloquent
 */
class ClassExaminationDiscount extends Common
{
    use HasFactory;

    // 关联考试
    public function examination()
    {
        return $this->belongsTo(ClassExamination::class, 'examination_id');
    }

    // 关联考试优惠类型
    public function type()
    {
        return $this->belongsTo(ClassExaminationDiscountType::class, 'discount_type_id');
    }

    // 关联创建人
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
