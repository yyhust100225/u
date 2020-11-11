<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\ClassExamination
 *
 * @property int $id
 * @property string $name 考试名称
 * @property int $announcement_id 公告ID
 * @property int $status 状态 0停用 1启用
 * @property string $remark 备注
 * @property int $user_id 创建人
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ClassAnnouncement $announcement
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|ClassExamination newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassExamination newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassExamination query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassExamination whereAnnouncementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassExamination whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassExamination whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassExamination whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassExamination whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassExamination whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassExamination whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassExamination whereUserId($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ClassExaminationDiscount[] $discounts
 * @property-read int|null $discounts_count
 */
class ClassExamination extends Common
{
    use HasFactory;

    // 关联从属公告
    public function announcement()
    {
        return $this->belongsTo(ClassAnnouncement::class, 'announcement_id');
    }

    // 关联创建人
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 管理已有优惠
    public function discounts()
    {
        return $this->hasMany(ClassExaminationDiscount::class, 'examination_id');
    }
}
