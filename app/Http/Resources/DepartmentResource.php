<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'p_name' => is_null($this->parent_department) ? trans('tips.no parent department') : $this->parent_department->name,
            'remark' => $this->remark,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
