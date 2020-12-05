<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'mobile' => $this->mobile,
            'examination_and_class_type' => trans('message.table.examination and class type', [
                'examination_name' => $this->class_type->examination->name,
                'class_type_name' => $this->class_type->name,
            ]),
            'class_open_date' => $this->class_open_date,

            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
