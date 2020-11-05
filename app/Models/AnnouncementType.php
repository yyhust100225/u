<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AnnouncementType
 *
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|AnnouncementType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AnnouncementType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AnnouncementType query()
 * @method static \Illuminate\Database\Eloquent\Builder|AnnouncementType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnnouncementType whereName($value)
 * @mixin \Eloquent
 */
class AnnouncementType extends Common
{
    use HasFactory;
    public $timestamps = false;
}
