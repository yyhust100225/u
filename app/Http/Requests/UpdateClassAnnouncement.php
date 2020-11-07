<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClassAnnouncement extends FormRequest
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
            'title' => ['required', 'min:2', Rule::unique('class_announcements')->ignore($this->input('id'))],
            'link' => ['nullable', 'url'],
            'candidate_num' => ['nullable', 'integer'],
            'written_exam_activity_num' => ['nullable', 'integer'],
            'written_exam_in_examination_num' => ['nullable', 'integer'],
            'interview_activity_num' => ['nullable', 'integer'],
            'pass_percent' => ['nullable', 'numeric', 'between:0,100']
        ];
    }

    public function attributes()
    {
        return [
            'title' => trans('validation.attributes.class_announcement_title'),
            'link' => trans('validation.attributes.class_announcement_link'),
            'candidate_num' =>trans('validation.attributes.candidate_num'),
            'written_exam_activity_num' => trans('validation.attributes.written_exam_activity_num'),
            'written_exam_in_examination_num' => trans('validation.attributes.written_exam_in_examination_num'),
            'interview_activity_num' => trans('validation.attributes.interview_activity_num'),
            'pass_percent' => trans('validation.attributes.pass_percent'),
        ];
    }
}
