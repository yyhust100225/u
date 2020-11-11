<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClassTypeDiscount extends FormRequest
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
            'amount' => ['required', 'numeric'],
        ];
    }

    public function attributes()
    {
        return [
            'name' => trans('validation.attributes.type_discount_name'),
            'amount' => trans('validation.attributes.type_discount_amount'),
        ];
    }
}
