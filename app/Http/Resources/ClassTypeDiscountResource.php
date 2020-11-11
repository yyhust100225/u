<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassTypeDiscountResource extends JsonResource
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
            'discount_name' => $this->name,
            'effect_time' => trans('message.table.time slot', ['start' => $this->start_date, 'end' => $this->end_date]),
            'amount' => $this->amount,
            'status' => $this->status,
            'user' => $this->user->username,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
