<?php

namespace App\Models\Maps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\Maps\MapStatementToExams
 *
 * @property int $id
 * @property int $statement_id 账单ID
 * @property int $exam_id 考试ID
 * @method static \Illuminate\Database\Eloquent\Builder|MapStatementToExams newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MapStatementToExams newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MapStatementToExams query()
 * @method static \Illuminate\Database\Eloquent\Builder|MapStatementToExams whereExamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MapStatementToExams whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MapStatementToExams whereStatementId($value)
 * @mixin \Eloquent
 */
class MapStatementToExams extends Model
{
    use HasFactory;

    // 保存对账单和考试映射
    public function saveStatementToExams($statement_id, $exams)
    {
        if(is_null($exams)) return false;

        $statement_to_exams = [];
        foreach($exams as $exam) {
            $statement_to_exams[] = ['statement_id' => $statement_id, 'exam_id' => $exam];
        }

        return DB::table($this->getTable())->where('statement_id', $statement_id)->delete() !== false && DB::table($this->getTable())->insert($statement_to_exams);
    }
}
