<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PrintedMatter
 *
 * @property int $id
 * @property string $name 印刷品名称
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PrintedMatter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PrintedMatter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PrintedMatter query()
 * @method static \Illuminate\Database\Eloquent\Builder|PrintedMatter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrintedMatter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrintedMatter whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrintedMatter whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PrintedMatter extends Common
{
    use HasFactory;
}
