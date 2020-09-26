<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Book
 *
 * @property int $id
 * @property string $name 图书名称
 * @property int $department_id 所属部门ID
 * @property int $quantity_total 总数
 * @property int $quantity_sold 售出数量
 * @property int $quantity_give 赠送数量
 * @property int $quantity_return 归还数量
 * @property int $quantity_usable 可用数量
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Department $department
 * @method static \Illuminate\Database\Eloquent\Builder|Book newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book query()
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereQuantityGive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereQuantityReturn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereQuantitySold($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereQuantityTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereQuantityUsable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Book extends Common
{
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
