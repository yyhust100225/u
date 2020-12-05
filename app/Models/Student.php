<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Student
 *
 * @property int $id
 * @property int $tq_id TQ学员信息ID
 * @property string $name 学员姓名
 * @property string $mobile 学员手机号
 * @property string $ID_card_no 学员身份证号
 * @property string $remark 学员备注
 * @property int $class_type_id 报名班型ID
 * @property string|null $class_open_date 开课日期
 * @property string $admission_ticket_no 准考证号
 * @property string $applicant_company 报考单位
 * @property string $applicant_job 报考职位
 * @property int $applicant_num 申请人数量
 * @property int $applicant_percent_molecule 招考比例分子
 * @property int $applicant_percent_denominator 招考比例分母
 * @property int $rank 排名
 * @property int $difference 分差
 * @property int $person_in_charge 咨询负责人
 * @property int $campus 所属校区
 * @property string $receivable_amount 应收款项
 * @property string $discount_amount 优惠金额
 * @property string $paid_amount 已缴金额
 * @property string $written_examination_refund 笔试退费金额
 * @property string $interview_refund 面试退费金额
 * @property int $user_id 录入人
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ClassCourseType $class_course_type
 * @property-read \App\Models\ClassType $class_type
 * @property-read \App\Models\Department $department
 * @method static \Illuminate\Database\Eloquent\Builder|Student newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student query()
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereAdmissionTicketNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereApplicantCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereApplicantJob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereApplicantNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereApplicantPercentDenominator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereApplicantPercentMolecule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereCampus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereClassCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereClassOpenDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereDifference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereIDCardNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereInterviewRefund($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student wherePaidAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student wherePersonInCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereReceivableAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereTqId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereWrittenExaminationRefund($value)
 * @mixin \Eloquent
 * @property-read \App\Models\ClassCourse $class_course
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\StudentDiscount[] $discounts
 * @property-read int|null $discounts_count
 */
class Student extends Common
{
    use HasFactory;

    // 关联班型表
    public function class_type()
    {
        return $this->belongsTo(ClassType::class, 'class_type_id');
    }

    // 关联开课校区
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    // 查询学员所享优惠
    public function discounts()
    {
        return $this->hasMany(StudentDiscount::class, 'student_id');
    }

    // 验证TQID是否唯一
    public function tqIdExists($tq_id)
    {
        return $this->where('tq_id', $tq_id)->exists();
    }
}
