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
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
