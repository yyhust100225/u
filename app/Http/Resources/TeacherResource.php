<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
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
            'tel' => $this->tel,
            'course_fee' => trans('message.table.course_fee', [
                'level' => $this->course_fee->name,
                'fee' => $this->course_fee->fee,
            ]),
            'group' => $this->group->name,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
