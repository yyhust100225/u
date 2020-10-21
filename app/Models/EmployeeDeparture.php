<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EmployeeDeparture
 *
 * @property int $id
 * @property int $employee_id 员工表ID
 * @property string|null $departure_date 离职时间
 * @property int $departure_type 离职方式 0辞职 1辞退
 * @property string $conversation_content 离职面谈详情
 * @property string $direction 离职去向
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeDeparture newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeDeparture newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeDeparture query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeDeparture whereConversationContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeDeparture whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeDeparture whereDepartureDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeDeparture whereDepartureType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeDeparture whereDirection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeDeparture whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeDeparture whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeDeparture whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EmployeeDeparture extends Model
{
    use HasFactory;
}
