<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\NoticeType
 *
 * @property int $id
 * @property string $name 要讯类型名称
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|NoticeType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NoticeType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NoticeType query()
 * @method static \Illuminate\Database\Eloquent\Builder|NoticeType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NoticeType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NoticeType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NoticeType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class NoticeType extends Common
{
    use HasFactory;
    public $timestamps = false;
}
