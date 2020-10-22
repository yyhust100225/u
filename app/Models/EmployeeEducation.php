<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EmployeeEducation
 *
 * @property int $id
 * @property int $employee_id 员工表ID
 * @property string $educational_background 学历背景
 * @property string $academic_degree 学位
 * @property string $major 专业
 * @property string $university 毕业院校
 * @property string $learn_model 学习模式
 * @property string $graduate_date 毕业时间
 * @property string $other_certificates 其他证书
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducation query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducation whereAcademicDegree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducation whereEducationalBackground($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducation whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducation whereGraduateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducation whereLearnModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducation whereMajor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducation whereOtherCertificates($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducation whereUniversity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeEducation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EmployeeEducation extends Common
{
    use HasFactory;
    protected $table = 'employee_educations';
}
