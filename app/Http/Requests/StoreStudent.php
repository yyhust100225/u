<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStudent extends FormRequest
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
            'name' => ['required', 'min:2', Rule::unique('class_courses')],
            'class_type_id' => ['required', 'integer', 'min:1'],
            'class_course_type_id' => ['required', 'integer', 'min:1'],
            'department_id' => ['required', 'integer', 'min:1'],
            'address' => ['required'],
            'class_course_date' => ['required'],
            'max_person_num' => ['required', 'integer'],
        ];
    }

    public function attributes()
    {
        return [
            'name' => trans('validation.attributes.class_course_name'),
            'class_type_id' => trans('validation.attributes.class_type_id'),
            'class_course_type_id' => trans('validation.attributes.class_course_type_id'),
            'department_id' => trans('validation.attributes.class_course_department_id'),
            'address' => trans('validation.attributes.class_course_address'),
            'class_course_date' => trans('validation.attributes.class_course_date'),
            'max_person_num' => trans('validation.attributes.max_person_num'),
        ];
    }
}
