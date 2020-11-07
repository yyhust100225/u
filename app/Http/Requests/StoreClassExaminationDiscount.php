<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClassExaminationDiscount extends FormRequest
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
            'examination_id' => ['required', 'integer'],
            'discount_type_id' => ['required', 'integer'],
            'amount' => ['required', 'numeric']
        ];
    }

    public function attributes()
    {
        return [
            'examination_id' => trans('validation.attributes.examination_id'),
            'discount_type_id' => trans('validation.attributes.discount_type_id'),
            'amount' => trans('validation.attributes.examination_discount_amount'),
        ];
    }
}
