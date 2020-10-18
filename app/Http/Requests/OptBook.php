<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OptBook extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'quantity_supplement' => ['numeric'],
            'quantity_sold' => ['numeric', 'nullable'],
            'quantity_give' => ['numeric', 'nullable'],
            'quantity_return' => ['numeric', 'nullable'],
        ];
    }
}
