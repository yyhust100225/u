<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\BookSale
 *
 * @property int $id
 * @property int $book_id 图书ID
 * @property int $department_id 归属部门
 * @property int $user_id 归属人ID
 * @property string $remark 销售记录备注
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
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
 * @property int $total_quantity 销售总数量
 * @property string $total_cost 总销售额
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BookBuyer[] $buyers
 * @property-read int|null $buyers_count
 * @method static \Illuminate\Database\Eloquent\Builder|BookSale whereTotalCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookSale whereTotalQuantity($value)
 */
class BookSale extends Common
{
    use HasFactory;

    // 关联书籍售卖信息买书用户
    public function buyers()
    {
        return $this->hasMany(BookBuyer::class, 'book_sale_id');
    }

    // 关联售卖记录的书籍信息
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    // 关联售卖记录部门信息
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    // 关联售卖记录账户信息
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
