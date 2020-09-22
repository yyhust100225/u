<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Common
{
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
