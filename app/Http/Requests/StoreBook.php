<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBook extends FormRequest
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
            'name' => ['required', 'min:2'],
            'quantity_total' => ['numeric'],
            'quantity_sold' => ['numeric'],
            'quantity_give' => ['numeric'],
            'quantity_return' => ['numeric'],
        ];
    }

    public function attributes()
    {
        return [
            'name' => trans('validation.attributes.book_name'),
        ];
    }
}
