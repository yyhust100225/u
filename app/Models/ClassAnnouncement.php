<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Exam
 *
 * @property int $id
 * @mixin \Eloquent
 * @property string $title 公告标题
 * @property int $city_id 城市ID
 * @property int $announcement_type 公告类型
 * @property string $link 链接
 * @property string $level 等级
 * @property string|null $publish_date 发布时间
 * @property int $candidate_num 招考人数
 * @property string|null $enroll_date_start 报名开始时间
 * @property string|null $enroll_date_end 报名截止时间
 * @property int $enroll_type 报名形式
 * @property int $exam_type 考试形式
 * @property int $written_exam_activity_num 笔试活动人数
 * @property string|null $written_exam_date 笔试考试时间
 * @property int $written_exam_class_open 笔试是否开课
 * @property int $written_exam_take_problem_sets 笔试是否拿习题
 * @property int $written_exam_in_examination_num 笔试参加开始人数
 * @property string|null $check_qualification_date 资格审查时间
 * @property int $interview_activity_num 面试活动人数
 * @property string|null $interview_date 面试时间
 * @property int $interview_class_open 面试是否开课
 * @property int $interview_take_problem_sets 面试是否拿题
 * @property string $pass_percent 自然通过率
 * @property int $status 公告状态
 * @property int $user_id 录入人
 * @method static \Illuminate\Database\Eloquent\Builder|ClassAnnouncement whereAnnouncementType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassAnnouncement whereCandidateNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassAnnouncement whereCheckQualificationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassAnnouncement whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassAnnouncement whereEnrollDateStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassAnnouncement whereEnrollEndStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassAnnouncement whereEnrollType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassAnnouncement whereExamType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassAnnouncement whereInterviewActivityNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassAnnouncement whereInterviewClassOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassAnnouncement whereInterviewDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassAnnouncement whereInterviewTakeProblemSets($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassAnnouncement whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassAnnouncement whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassAnnouncement wherePassPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassAnnouncement wherePublishDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassAnnouncement whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassAnnouncement whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassAnnouncement whereWrittenExamActivityNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassAnnouncement whereWrittenExamClassOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassAnnouncement whereWrittenExamDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassAnnouncement whereWrittenExamInExaminationNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassAnnouncement whereWrittenExamTakeProblemSets($value)
 */
class ClassAnnouncement extends Common
{
    use HasFactory;
}
