<?php

namespace App\Models\Maps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
