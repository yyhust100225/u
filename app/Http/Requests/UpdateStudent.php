<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudent extends FormRequest
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
            'class_type_id' => ['required', 'integer', 'min:1'],
        ];
    }

    public function attributes()
    {
        return [
            'name' => trans('validation.attributes.student_name'),
            'class_type_id' => trans('validation.attributes.class_type'),
        ];
    }
}
