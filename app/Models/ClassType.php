<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\ClassType
 *
 * @property int $id
 * @property string $name 班型名称
 * @property int $examination_id 所属考试ID
 * @property int $is_agreement_class 是否为协议班 0否 1是
 * @property int $exam_type 考试形式
 * @property int $written_examination_days 笔试白天数
 * @property int $written_examination_nights 笔试夜晚数
 * @property int $interview_days 面试白天数
 * @property int $interview_nights 面试夜晚数
 * @property string $total_tuition 总学费
 * @property string $per_day_tuition 每日学费
 * @property string $written_examination_refund 笔试退款
 * @property string $interview_refund 面试退款
 * @property int $status 班型状态 0关闭 1开启
 * @property string $remark 备注
 * @property int $user_id 录入人
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ClassTypeDiscount[] $discounts
 * @property-read int|null $discounts_count
 * @property-read \App\Models\ClassExamination $examination
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|ClassType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassType query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassType whereExamType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassType whereExaminationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassType whereInterviewDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassType whereInterviewNights($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassType whereInterviewRefund($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassType whereIsAgreementClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassType wherePerDayTuition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassType whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassType whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassType whereTotalTuition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassType whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassType whereWrittenExaminationDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassType whereWrittenExaminationNights($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassType whereWrittenExaminationRefund($value)
 * @mixin \Eloquent
 */
class ClassType extends Common
{
    use HasFactory;

    // 关联从属公告
    public function examination()
    {
        return $this->belongsTo(ClassExamination::class, 'examination_id');
    }

    // 关联创建人
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 管理已有优惠
    public function discounts()
    {
        return $this->hasMany(ClassTypeDiscount::class, 'type_id');
    }
}
