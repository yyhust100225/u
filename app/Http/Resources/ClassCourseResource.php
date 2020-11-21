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
            'name' => $this->name,
            'examination_name' => $this->class_type->examination->name,
            'class_type_name' => $this->class_type->name,
            'class_course_type_name' => $this->class_course_type->name,
            'total_tuition' => $this->class_type->total_tuition,
            'is_agreement_class' => $this->class_type->is_agreement_class,
            'department_name' => $this->department->name,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
