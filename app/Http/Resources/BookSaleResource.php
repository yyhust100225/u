<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookSaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'book_name' => $this->book->name,
            'department_name' => $this->department->name,
            'user_name' => $this->user->username,
            'total_quantity' => $this->total_quantity,
            'total_cost' => $this->total_cost,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
