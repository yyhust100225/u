<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'department_name' => $this->department->name,
            'quantity_total' => $this->quantity_total,
            'quantity_sold' => $this->quantity_sold,
            'quantity_give' => $this->quantity_give,
            'quantity_return' => $this->quantity_return,
            'quantity_usable' => $this->quantity_usable,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
