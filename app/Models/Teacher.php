<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Teacher
 *
 * @property int $id
 * @property string $name 老师姓名
 * @property string $nickname 老师艺名
 * @property string $tel 联系方式
 * @property int $course_fee_id 课时费ID
 * @property int $teacher_group_id 教师分组ID
 * @property string $remark 备注
 * @property int $user_id 录入人
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher query()
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereCourseFeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereTeacherGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereTel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\CourseFee $course_fee
 * @property-read \App\Models\TeacherGroup $group
 */
class Teacher extends Common
{
    use HasFactory;

    // 关联讲师分组
    public function group()
    {
        return $this->belongsTo(TeacherGroup::class, 'teacher_group_id');
    }

    // 关联课时费用
    public function course_fee()
    {
        return $this->belongsTo(CourseFee::class, 'course_fee_id');
    }
}
