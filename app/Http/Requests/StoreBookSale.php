<?php

namespace App\Http\Requests;

use App\Rules\UnsignedFloat;
use App\Rules\UnsignedInteger;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookSale extends FormRequest
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
            'book_id' => ['required', 'numeric', 'min:1'],
            'department_id' => ['required', 'numeric', 'min:1'],
            'user_id' => ['required', 'numeric', 'min:1'],

            'name.*' => ['required', 'max:6'],
            'quantity.*' => ['required', new UnsignedInteger()],
            'cost.*' => ['required', new UnsignedFloat()],
        ];
    }

    public function attributes()
    {
        return [
            'name.*' => trans('validation.attributes.book_sale_name'),
            'quantity.*' => trans('validation.attributes.book_sale_quantity'),
            'cost.*' => trans('validation.attributes.book_sale_cost'),
        ];
    }

    public function messages()
    {
        return [
            'name.*.required' => trans('validation.book_sale_name_null'),
        ];
    }
}
