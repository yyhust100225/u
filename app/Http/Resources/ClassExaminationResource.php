<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassExaminationResource extends JsonResource
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
            'announcement' => $this->announcement->title,
            'status' => $this->status,
            'user' => $this->user->username,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
