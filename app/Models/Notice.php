<?php

namespace App\Models;

use App\Models\Maps\MapNoticeToDepartments;
use App\Models\Maps\MapNoticeToUsers;
use App\Models\Maps\MapNoticeToRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 查询可见要讯
    public function canViewNotices($page, $limit, $where, $userinfo)
    {
        $table_name = $this->getTable();

        $db = $this->newQuery()
            ->distinct()
            ->leftJoin('map_notice_to_users as mu', $table_name.'.id', '=', 'mu.notice_id')
            ->leftJoin('map_notice_to_roles as mr', $table_name.'.id', '=', 'mr.notice_id')
            ->leftJoin('map_notice_to_departments as md', $table_name.'.id', '=', 'md.notice_id');

        foreach($where as $field => $value) {
            if(is_array($value)) {
                if($value[0] == 'in')
                    $db->whereIn($field, $value[1]);
                else
                    $db->where($field, $value[0], $value[1]);
            }
            else
                $db->where($field, $value);
        }

        $db->where(function($query) use($userinfo){
            $query->where('mu.user_id', $userinfo['user_id'])
                ->orWhere('mr.role_id', $userinfo['role_id'])
                ->orWhere('md.department_id', $userinfo['department_id']);
        });

        $count = $db->count('notices.id');

        $data = $db
            ->offset(($page - 1) * $limit)->limit($limit)
            ->get(['notices.*']);

        return ['count' => $count, 'data' => $data];
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

    // 关联要讯审批人
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id', 'id');
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
