<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ClassTypeDiscount
 *
 * @property-read \App\Models\ClassType $type
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|ClassTypeDiscount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassTypeDiscount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassTypeDiscount query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $type_id 所属班型ID
 * @property string $name 优惠名称
 * @property int $status 状态
 * @property int $user_id 录入人
 * @property string $remark 备注
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ClassTypeDiscount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassTypeDiscount whereEndDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassTypeDiscount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassTypeDiscount whereMoney($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassTypeDiscount whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassTypeDiscount whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassTypeDiscount whereStartDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassTypeDiscount whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassTypeDiscount whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassTypeDiscount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassTypeDiscount whereUserId($value)
 * @property string $amount 优惠价格
 * @property string $start_date 开始日期
 * @property string $end_date 结束日期
 * @method static \Illuminate\Database\Eloquent\Builder|ClassTypeDiscount whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassTypeDiscount whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassTypeDiscount whereStartDate($value)
 */
class ClassTypeDiscount extends Common
{
    use HasFactory;

    // 关联考试
    public function type()
    {
        return $this->belongsTo(ClassType::class, 'type_id');
    }

    // 关联创建人
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
