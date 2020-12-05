<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClassCourseResource extends JsonResource
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
            'examination_id' => $this->class_type->examination->id,
            'name' => $this->name,
            'examination_name' => $this->class_type->examination->name,
            'class_type_name' => $this->class_type->name,
            'class_course_type_name' => $this->class_course_type->name,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
