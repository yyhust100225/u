<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClassTypeDiscount extends FormRequest
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
            'type_id' => ['required', 'integer'],
            'name' => ['required', 'min:2'],
            'amount' => ['required', 'numeric'],
        ];
    }

    public function attributes()
    {
        return [
            'type_id' => trans('validation.attributes.type_id'),
            'name' => trans('validation.attributes.type_discount_name'),
            'amount' => trans('validation.attributes.type_discount_amount'),
        ];
    }
}
