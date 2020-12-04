<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTeacher extends FormRequest
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
            'course_fee_id' => ['required', 'integer', 'min:1'],
            'teacher_group_id' => ['required', 'integer', 'min:1'],
        ];
    }

    public function attributes()
    {
        return [
            'name' => trans('validation.attributes.teacher_name'),
            'course_fee_id' => trans('validation.attributes.course_fee_id'),
            'teacher_group_id' => trans('validation.attributes.teacher_group_id'),
        ];
    }
}
