<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BookSale
 *
 * @property int $id
 * @property int $book_id 图书ID
 * @property int $department_id 归属部门
 * @property int $user_id 归属人ID
 * @property string $remark 销售记录备注
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BookSale newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookSale newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookSale query()
 * @method static \Illuminate\Database\Eloquent\Builder|BookSale whereBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookSale whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookSale whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookSale whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookSale whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookSale whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookSale whereUserId($value)
 * @mixin \Eloquent
 */
class BookSale extends Common
{
    use HasFactory;
}
