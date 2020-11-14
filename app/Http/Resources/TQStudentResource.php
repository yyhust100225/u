<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TQStudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'tq_id' => $this->tq_id,
            'name' => $this->name,
            'mobile' => $this->mobile,
            'level' => $this->level,
            'remark' => $this->remark,
            'insert_time' => $this->insert_time,
            'create_time' => $this->create_time,
        ];
    }
}
