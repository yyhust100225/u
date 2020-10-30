<?php

namespace App\Models;

use App\Models\Maps\MapNoticeToDepartments;
use App\Models\Maps\MapNoticeToUsers;
use App\Models\Maps\MapNoticeToRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Notice
 *
 * @property int $id
 * @property string $title 要讯标题
 * @property int $notice_type_id 要讯种类
 * @property string $start_time 开始时间
 * @property string $end_time 结束时间
 * @property string $file 要讯附件
 * @property string $content 要讯内容
 * @property int $user_id 创建用户ID
 * @property int $status 要讯状态
 * @property int $reviewer_id 审核人ID
 * @property string|null $review_time 审核时间
 * @property string $review_remark 审核备注
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Notice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notice query()
 * @method static \Illuminate\Database\Eloquent\Builder|Notice whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notice whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notice whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notice whereNoticeTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notice whereReviewRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notice whereReviewTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notice whereReviewerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notice whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notice whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notice whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notice whereUserId($value)
 * @mixin \Eloquent
 * @property int $file_id 要讯附件文件ID
 * @method static \Illuminate\Database\Eloquent\Builder|Notice whereFileId($value)
 */
class Notice extends Common
{
    use HasFactory;

    public function notice_type()
    {
        return $this->belongsTo(NoticeType::class);
    }

    // 关联要讯抄送的所有部门
    public function departments()
    {
        return $this->hasManyThrough(Department::class, MapNoticeToDepartments::class, 'notice_id', 'id', 'id', 'department_id');
    }

    // 关联要讯抄送的所有角色
    public function roles()
    {
        return $this->hasManyThrough(Role::class, MapNoticeToRoles::class, 'notice_id', 'id', 'id', 'role_id');
    }

    // 关联要讯抄送的所有用户
    public function users()
    {
        return $this->hasManyThrough(User::class, MapNoticeToUsers::class, 'notice_id', 'id', 'id', 'user_id');
    }

    // 关联要讯附件
    public function file()
    {
        return $this->hasOne(File::class, 'id', 'file_id');
    }

    // 关联所有抄送部门ID
    public function departmentIds()
    {
        return $this->hasMany(MapNoticeToDepartments::class);
    }

    // 关联所有抄送部门ID
    public function roleIds()
    {
        return $this->hasMany(MapNoticeToRoles::class);
    }

    // 关联所有抄送部门ID
    public function userIds()
    {
        return $this->hasMany(MapNoticeToUsers::class);
    }
}
