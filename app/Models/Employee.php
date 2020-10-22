<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Employee
 *
 * @property int $id
 * @property string $name 员工姓名
 * @property int $user_id 账户表ID
 * @property int $status 员工状态 0试用期 1正式 2离职
 * @property string $job_no 员工工号
 * @property int $department_id 部门ID
 * @property int $group_id 组别ID
 * @property int $job_id 职务ID
 * @property string $TQ_no 员工TQ号
 * @property string $level 员工等级
 * @property string $alias 教师别名(艺名)
 * @property int $gender 员工性别 0男 1女
 * @property int $nation_id 民族
 * @property int $political_status 政治身份 0群众 1党员
 * @property int $marry 婚姻状态 0未婚 1已婚
 * @property int $register_residence_type 户口类型 0农村 1城镇
 * @property string|null $hire_date 入职日期
 * @property string|null $regular_date 转正日期
 * @property string|null $insurance_date 入保日期
 * @property string|null $last_contract_date 合同签署日期
 * @property string|null $contract_expire_date 合同到期日期
 * @property int $insurance_area_id 缴纳保险地区ID
 * @property string $staff_no 职员编号
 * @property string $paf_no 公积金账号
 * @property string $mic_no 医保卡账号
 * @property int $teacher_certification 教师资格证 0未持有 1持有
 * @property string|null $birthday 员工生日
 * @property string $id_card_no 员工身份证号
 * @property string $id_card_address 身份证地址
 * @property string $current_address 现居住地址
 * @property string $tel 电话号/联系方式
 * @property string $emergency_contact 紧急联系人
 * @property string $emergency_tel 紧急联系方式
 * @property string $bank_card_no_5 工资卡号(5日)
 * @property string $bank_of_account_5 开户行(5日)
 * @property string $bank_card_no_10 工资卡号(10日)
 * @property string $bank_of_account_10 开户行(10日)
 * @property string $work_experience 员工工作经历
 * @property string $exception_action 员工异动记录
 * @property string $leave_records 员工休假记录
 * @property string $remark 员工备注
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EmployeeDeparture|null $departure
 * @property-read \App\Models\EmployeeEducation|null $education
 * @property-read \App\Models\EmployeeSalary|null $salary
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereBankCardNo10($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereBankCardNo5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereBankOfAccount10($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereBankOfAccount5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereContractExpireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCurrentAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereEmergencyContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereEmergencyTel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereExceptionAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereHireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereIdCardAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereIdCardNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereInsuranceAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereInsuranceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereJobId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereJobNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereLastContractDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereLeaveRecords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereMarry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereMicNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereNationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePafNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePoliticalStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereRegisterResidenceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereRegularDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereStaffNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereTQNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereTeacherCertification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereTel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereWorkExperience($value)
 * @mixin \Eloquent
 * @property int $regular 是否转正
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereRegular($value)
 */
class Employee extends Common
{
    use HasFactory;

    // 关联员工离职表
    public function departure()
    {
        return $this->hasOne(EmployeeDeparture::class, 'employee_id');
    }

    // 关联员工教育经历表
    public function education()
    {
        return $this->hasOne(EmployeeEducation::class, 'employee_id');
    }

    // 关联员工薪资表
    public function salary()
    {
        return $this->hasOne(EmployeeSalary::class, 'employee_id');
    }
}
