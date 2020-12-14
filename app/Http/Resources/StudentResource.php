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
        $already_paid_amount = bcadd($this->payments->sum('total_amount'), 0.00, 2);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'mobile' => $this->mobile,
            'examination_and_class_type' => trans('message.table.examination and class type', [
                'examination_name' => $this->class_type->examination->name,
                'class_type_name' => $this->class_type->name,
            ]),
            'class_open_date' => $this->class_open_date,
            'receivable_amount' => $this->receivable_amount,
            'discount_amount' => $this->discount_amount,
            'paid_amount' => $this->paid_amount,
            'already_paid_amount' => $already_paid_amount,
            'paid_status' => bcsub($already_paid_amount, $this->paid_amount, 2),

            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
