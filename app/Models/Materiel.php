<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Materiel
 *
 * @property int $id
 * @property string $name 物料名称
 * @property int $department_id 所属部门ID
 * @property int $quantity_total 总数
 * @property int $quantity_scrap 报废数量
 * @property int $quantity_consume 消耗数量
 * @property int $quantity_incomplete 零件残缺数量
 * @property int $quantity_usable 可用数量
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Department $department
 * @method static \Illuminate\Database\Eloquent\Builder|Materiel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Materiel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Materiel query()
 * @method static \Illuminate\Database\Eloquent\Builder|Materiel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Materiel whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Materiel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Materiel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Materiel whereQuantityConsume($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Materiel whereQuantityIncomplete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Materiel whereQuantityScrap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Materiel whereQuantityTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Materiel whereQuantityUsable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Materiel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Materiel extends Common
{
    use HasFactory;

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
