<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStatement extends FormRequest
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
            'publish_date' => ['required', 'date_format:Y-m-d'],
            'exam_categories' => ['required'],
            'exams' => ['required'],
            'quantity_print' => ['required', 'integer'],
            'price_print' => ['required', 'numeric'],
            'designer_quote_price' => ['required', 'numeric'],
        ];
    }

    public function messages()
    {
        return [
            'exams.required' => trans('validation.exams_null'),
            'exam_categories.required' => trans('validation.exams_null'),
            'publish_date.date_format' => trans('validation.publish_date_format'),
        ];
    }
}
