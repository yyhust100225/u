<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentPaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $methods = [];
        foreach($this->payment_details->pluck('payment_method') as $item) {
            $methods[] = trans('message.table.pay.method_'.$item);
        }

        return [
            'id' => $this->id,
            'payment_date' => $this->payment_date,
            'payment_place' => $this->department->name,
            'bill_no' => $this->bill_no,
            'payment_type' => trans('message.table.pay.type_'.$this->payment_type),
            'total_amount' => $this->total_amount,
            'remark' => $this->remark,
            'user' => $this->user->username,
            'pay_methods' => implode(',', $methods),
            'pay_amounts' => implode(',', $this->payment_details->pluck('pay_amount')->toArray()),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
