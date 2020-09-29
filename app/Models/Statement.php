<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Statement
 *
 * @property int $id
 * @property int $printer_id 印刷厂ID
 * @property int $publisher_id 发稿人ID
 * @property string $publish_date 发稿日期
 * @property int $department_id 部门ID
 * @property int $exam_category_id 考试大类ID
 * @property int $exam_id 考试ID
 * @property int $printed_matter_id 印刷品ID
 * @property string $print_detail 印刷明细
 * @property int $quantity_print 印刷品数量
 * @property string $price_print 印刷品单价
 * @property string $printer_quote_price 印刷厂报价
 * @property string $designer_quote_price 设计师报价
 * @property string $applicant 申请人
 * @property string $remark 对账单备注
 * @property int $status 账单状态
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Statement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Statement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Statement query()
 * @method static \Illuminate\Database\Eloquent\Builder|Statement whereApplicant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Statement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Statement whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Statement whereDesignerQuotePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Statement whereExamCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Statement whereExamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Statement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Statement wherePricePrint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Statement wherePrintDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Statement wherePrintedMatterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Statement wherePrinterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Statement wherePrinterQuotePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Statement wherePublishDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Statement wherePublisherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Statement whereQuantityPrint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Statement whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Statement whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Statement whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Statement extends Common
{
    use HasFactory;
}
