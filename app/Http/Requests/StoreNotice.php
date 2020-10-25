<?php

namespace App\Http\Requests;

use App\Rules\AtLeastOne;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreNotice extends FormRequest
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
            'title' => ['required', 'min:2', Rule::unique('notices')],
            'start_time' => ['required'],
            'end_time' => ['required', 'date', 'after_or_equal:start_time'],
            'department_ids' => [new AtLeastOne($this, ['role_ids', 'user_ids'])],
            'content' => ['required']
        ];
    }

    public function attributes()
    {
        return [
            'title' => trans('validation.attributes.notice_title'),
            'content' => trans('validation.attributes.notice_content'),
        ];
    }
}
