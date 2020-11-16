<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

/**
 * App\Models\TQ
 *
 * @property int $id
 * @property int $tq_id TQ ID号
 * @property string $address 学员现居地址
 * @property string $mobile 学员联系方式
 * @property string $name 学员姓名
 * @property string $qq 学员QQ号
 * @property string $level 客户级别
 * @property string|null $remark 最近备注
 * @property int $gender 客户性别 0男 1女
 * @property string $telephone 客户联系方式
 * @property string $wechat 客户微信号
 * @property string $creator_uin 录入人uin
 * @property string $insert_date 录入日期
 * @property string|null $last_contact_date 上次联系日期
 * @property int $phone_calls 去电次数
 * @property string $uin 客户uin
 * @property string|null $update_time 最后更新日期
 * @property int $department_id 所属部门
 * @property int $party_number 是否为党员 0非党员 1党员
 * @property string $attestation 资格证
 * @property string $school 毕业院校
 * @property string $major 专业
 * @property string $company 报考单位
 * @property string $job 报考职位
 * @property string $ID_card_no 身份证号
 * @property string $examination 考试
 * @property string $class_type 班型
 * @property string $political 政治面貌
 * @property string $english_level 英语四六级
 * @property string $current_address 目前所在地
 * @property string $resource_owner 资源获取人
 * @property string $resource_activity 资源归属活动
 * @property string|null $visit_back_date 回访日期
 * @property string|null $call_back_date 回拨日期
 * @property int $way_to_visit 来访途径
 * @property int $exam_type 考试方式 0笔试 1面试
 * @property int $belong_to 归属地
 * @property int $education 学历
 * @property int $identity 考生身份
 * @property int $common_tested 参加公考
 * @property int $trained 参加培训
 * @property int $resource_method 获取资源方式
 * @property int $belongs_to_department 资源归属部门
 * @property int $tq_synchronization 是否从TQ中录入本地库 1否 2是
 * @property int $user_id 录入人
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|TQ newModelQuery()
 * @method static Builder|TQ newQuery()
 * @method static Builder|TQ query()
 * @method static Builder|TQ whereAddress($value)
 * @method static Builder|TQ whereAttestation($value)
 * @method static Builder|TQ whereBelongTo($value)
 * @method static Builder|TQ whereBelongsToDepartment($value)
 * @method static Builder|TQ whereCallBackDate($value)
 * @method static Builder|TQ whereClassType($value)
 * @method static Builder|TQ whereCommonTested($value)
 * @method static Builder|TQ whereCompany($value)
 * @method static Builder|TQ whereCreatedAt($value)
 * @method static Builder|TQ whereCreatorUin($value)
 * @method static Builder|TQ whereCurrentAddress($value)
 * @method static Builder|TQ whereDepartmentId($value)
 * @method static Builder|TQ whereEducation($value)
 * @method static Builder|TQ whereEnglishLevel($value)
 * @method static Builder|TQ whereExamType($value)
 * @method static Builder|TQ whereExamination($value)
 * @method static Builder|TQ whereGender($value)
 * @method static Builder|TQ whereIDCardNo($value)
 * @method static Builder|TQ whereId($value)
 * @method static Builder|TQ whereIdentity($value)
 * @method static Builder|TQ whereInsertDate($value)
 * @method static Builder|TQ whereJob($value)
 * @method static Builder|TQ whereLastContactDate($value)
 * @method static Builder|TQ whereLevel($value)
 * @method static Builder|TQ whereMajor($value)
 * @method static Builder|TQ whereMobile($value)
 * @method static Builder|TQ whereName($value)
 * @method static Builder|TQ wherePartyNumber($value)
 * @method static Builder|TQ wherePhoneCalls($value)
 * @method static Builder|TQ wherePolitical($value)
 * @method static Builder|TQ whereQq($value)
 * @method static Builder|TQ whereRemark($value)
 * @method static Builder|TQ whereResourceActivity($value)
 * @method static Builder|TQ whereResourceMethod($value)
 * @method static Builder|TQ whereResourceOwner($value)
 * @method static Builder|TQ whereSchool($value)
 * @method static Builder|TQ whereTelephone($value)
 * @method static Builder|TQ whereTqId($value)
 * @method static Builder|TQ whereTqSynchronization($value)
 * @method static Builder|TQ whereTrained($value)
 * @method static Builder|TQ whereUin($value)
 * @method static Builder|TQ whereUpdateTime($value)
 * @method static Builder|TQ whereUpdatedAt($value)
 * @method static Builder|TQ whereUserId($value)
 * @method static Builder|TQ whereVisitBackDate($value)
 * @method static Builder|TQ whereWayToVisit($value)
 * @method static Builder|TQ whereWechat($value)
 * @mixin Eloquent
 * @property string $admin_uin 校区TQ总账户号
 * @property string $insert_time 资源录入时间
 * @property string|null $last_contact_time 上次联系时间
 * @property string $create_time 录入时间
 * @method static Builder|TQ whereAdminUin($value)
 * @method static Builder|TQ whereCreateTime($value)
 * @method static Builder|TQ whereInsertTime($value)
 * @method static Builder|TQ whereLastContactTime($value)
 */
class TQ extends Common
{
    protected $table = 'tq_students';
    public $timestamps = false;

    use HasFactory;
}
