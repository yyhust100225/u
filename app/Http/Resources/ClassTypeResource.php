<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassTypeResource extends JsonResource
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
            'name' => $this->name,
            'examination' => $this->examination->name,
            'status' => $this->status,
            'user' => $this->user->username,
            'total_tuition' => $this->total_tuition,
            'written_examination_refund' => $this->written_examination_refund,
            'interview_refund' => $this->interview_refund,
            'is_agreement_class' => $this->is_agreement_class,
            'created_at' => $this->created_at->toDateTimeString(),

            'class_examination_discounts' => $this->examination->discountsWithName(),
            'class_type_discounts' => $this->discounts,
        ];
    }
}
