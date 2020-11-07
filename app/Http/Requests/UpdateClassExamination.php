<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClassExamination extends FormRequest
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
            'announcement_id' => ['required', 'integer'],
        ];
    }

    public function attributes()
    {
        return [
            'name' => trans('validation.attributes.class_examination_name'),
            'announcement_id' => trans('validation.attributes.announcement_id'),
        ];
    }
}
