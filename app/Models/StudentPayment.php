<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\StudentPayment
 *
 * @property int $id
 * @property int $student_id 学生ID
 * @property string $total_amount 实缴金额
 * @property string $payment_date 缴费日期
 * @property int $payment_place 缴费地
 * @property string $bill_no 票据号
 * @property int $payment_type 缴费类型
 * @property string $remark 缴费备注
 * @property int $user_id 录入人
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\StudentPaymentDetail[] $details
 * @property-read int|null $details_count
 * @property-read \App\Models\Student $student
 * @method static \Illuminate\Database\Eloquent\Builder|StudentPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentPayment whereBillNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentPayment wherePaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentPayment wherePaymentPlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentPayment wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentPayment whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentPayment whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentPayment whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentPayment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentPayment whereUserId($value)
 * @mixin \Eloquent
 */
class StudentPayment extends Common
{
    use HasFactory;

    // 关联学生表
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // 关联缴费详情
    public function details()
    {
        return $this->hasMany(StudentPaymentDetail::class, 'payment_id');
    }
}
