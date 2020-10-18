<?php

namespace App\Models\Maps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\Maps\MapStatementToExamCategories
 *
 * @property int $id
 * @property int $statement_id 账单ID
 * @property int $exam_category_id 考试大类ID
 * @method static \Illuminate\Database\Eloquent\Builder|MapStatementToExamCategories newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MapStatementToExamCategories newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MapStatementToExamCategories query()
 * @method static \Illuminate\Database\Eloquent\Builder|MapStatementToExamCategories whereExamCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MapStatementToExamCategories whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MapStatementToExamCategories whereStatementId($value)
 * @mixin \Eloquent
 */
class MapStatementToExamCategories extends Model
{
    use HasFactory;

    // 保存对账单和考试大类映射
    public function saveStatementToExamCategories($statement_id, $exam_categories)
    {
        if(is_null($exam_categories)) return false;

        $statement_to_exam_categories = [];
        foreach($exam_categories as $exam_category) {
            $statement_to_exam_categories[] = ['statement_id' => $statement_id, 'exam_category_id' => $exam_category];
        }

        return DB::table($this->getTable())->where('statement_id', $statement_id)->delete() !== false && DB::table($this->getTable())->insert($statement_to_exam_categories);
    }
}
