<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MaterielResource extends JsonResource
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
            'quantity_scrap' => $this->quantity_scrap,
            'quantity_consume' => $this->quantity_consume,
            'quantity_incomplete' => $this->quantity_incomplete,
            'quantity_usable' => $this->quantity_usable,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
