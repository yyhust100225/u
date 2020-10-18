<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StatementResource extends JsonResource
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
            'printer_name' => $this->printer->name,
            'applicant' => $this->applicant,
            'publish_date' => $this->publish_date,
            'department_name' => $this->department->name,
            'printed_matter_name' => $this->printed_matter->name,
            'print_detail' => $this->print_detail,
            'quantity_print' => $this->quantity_print,
            'price_print' => $this->price_print,
            'designer_quote_price' => $this->designer_quote_price,
            'printer_quote_price' => $this->printer_quote_price,
            'status' => $this->status,
            'remark' => $this->remark,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
