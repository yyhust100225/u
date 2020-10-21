<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EmployeeSalary
 *
 * @property int $id
 * @property int $employee_id 员工表ID
 * @property string $base_salary_1 基本工资1
 * @property string $base_salary_2 基本工资2
 * @property string $merits_salary 绩效工资
 * @property string $job_subsidy 岗位补助
 * @property string $live_subsidy 生活补助
 * @property string $local_subsidy 地方补助
 * @property string $public_service_subsidy 公共服务补助
 * @property string $class_subsidy 课时补助
 * @property string $no_insurance_subsidy 放弃保险补助
 * @property string $other_subsidy 其他补助
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSalary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSalary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSalary query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSalary whereBaseSalary1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSalary whereBaseSalary2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSalary whereClassSubsidy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSalary whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSalary whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSalary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSalary whereJobSubsidy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSalary whereLiveSubsidy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSalary whereLocalSubsidy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSalary whereMeritsSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSalary whereNoInsuranceSubsidy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSalary whereOtherSubsidy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSalary wherePublicServiceSubsidy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeSalary whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EmployeeSalary extends Model
{
    use HasFactory;
}
