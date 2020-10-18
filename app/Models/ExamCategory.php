<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ExamCategory
 *
 * @property int $id
 * @property string $name 考试大类名称
 * @property string $remark 考试大类备注
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ExamCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamCategory whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ExamCategory extends Common
{
    use HasFactory;
}
