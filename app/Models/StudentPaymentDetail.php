<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\StudentPaymentDetail
 *
 * @property int $id
 * @property int $payment_id 缴费记录ID
 * @property int $payment_method 缴费方式
 * @property string $pay_amount 缴费数额
 * @property-read \App\Models\StudentPayment $payment
 * @method static \Illuminate\Database\Eloquent\Builder|StudentPaymentDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentPaymentDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentPaymentDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentPaymentDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentPaymentDetail wherePayAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentPaymentDetail wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentPaymentDetail wherePaymentMethod($value)
 * @mixin \Eloquent
 */
class StudentPaymentDetail extends Common
{
    use HasFactory;

    // 关联学生缴费信息
    public function payment()
    {
        return $this->belongsTo(StudentPayment::class, 'payment_id');
    }
}
