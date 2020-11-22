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
            'total_tuition' => $this->class_type->total_tuition,
            'written_examination_refund' => $this->class_type->written_examination_refund,
            'interview_refund' => $this->class_type->interview_refund,
            'is_agreement_class' => $this->class_type->is_agreement_class,
            'department_name' => $this->department->name,

            'class_examination_discounts' => $this->class_type->examination->discountsWithName(),
            'class_type_discounts' => $this->class_type->discounts,

            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
