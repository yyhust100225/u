<?php

namespace App\Models\Maps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
