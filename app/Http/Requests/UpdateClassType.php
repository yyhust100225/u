<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClassType extends FormRequest
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
            'name' => ['required', 'min:2', Rule::unique('class_examinations')->ignore($this->input('id'))],
            'examination_id' => ['required', 'integer'],
            'written_examination_days' => ['nullable', 'integer'],
            'written_examination_nights' => ['nullable', 'integer'],
            'interview_days' => ['nullable', 'integer'],
            'interview_nights' => ['nullable', 'integer'],
            'total_tuition' => ['nullable', 'numeric'],
            'per_day_tuition' => ['nullable', 'numeric'],
            'written_examination_refund' => ['nullable', 'numeric'],
            'interview_refund' => ['nullable', 'numeric'],
        ];
    }

    public function attributes()
    {
        return [
            'name' => trans('validation.attributes.class_type_name'),
            'examination_id' => trans('validation.attributes.examination_id'),
            'written_examination_days' => trans('validation.attributes.written_examination_days'),
            'written_examination_nights' => trans('validation.attributes.written_examination_nights'),
            'interview_days' => trans('validation.attributes.interview_days'),
            'interview_nights' => trans('validation.attributes.interview_nights'),
            'total_tuition' => trans('validation.attributes.total_tuition'),
            'per_day_tuition' => trans('validation.attributes.per_day_tuition'),
            'written_examination_refund' => trans('validation.attributes.written_examination_refund'),
            'interview_refund' => trans('validation.attributes.interview_refund'),
        ];
    }
}
