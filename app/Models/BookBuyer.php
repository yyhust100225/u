<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\BookBuyer
 *
 * @property int $id
 * @property int $book_sale_id 图书销售ID
 * @property string $name 买家姓名
 * @property int $gender 性别 0男 1女
 * @property string $id_number 身份证号
 * @property string $tel 联系方式
 * @property int $quantity 销售数量
 * @property int $payment_method 缴费方式
 * @property string $cost 销售费用
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BookBuyer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookBuyer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookBuyer query()
 * @method static \Illuminate\Database\Eloquent\Builder|BookBuyer whereBookSaleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookBuyer whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookBuyer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookBuyer whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookBuyer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookBuyer whereIdNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookBuyer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookBuyer wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookBuyer whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookBuyer whereTel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookBuyer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BookBuyer extends Common
{
    use HasFactory;
    public $timestamps = false;

    public function saveBookBuyers($book_sale_id, $buyers)
    {
        if(is_null($buyers)) return false;

        $book_buyers = [];
        foreach($buyers as $buyer) {
            $book_buyers[] = [
                'book_sale_id' => $book_sale_id,
                'name' => $buyer['name'],
                'gender' => $buyer['gender'],
                'id_number' => $buyer['id_number'],
                'tel' => $buyer['tel'],
                'quantity' => $buyer['quantity'],
                'payment_method' => $buyer['payment_method'],
                'cost' => $buyer['cost'],
            ];
        }

        return DB::table($this->getTable())->where('book_sale_id', $book_sale_id)->delete() !== false && DB::table($this->getTable())->insert($book_buyers);
    }
}
