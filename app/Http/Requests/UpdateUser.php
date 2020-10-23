<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UpdateUser extends FormRequest
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
            'username' => ['required', 'min:2', Rule::unique('users')->ignore($this->input('id'))],
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->input('id'))],
        ];
    }

    public function messages()
    {
        return [
            'username.unique' => trans('validation.username_unique'),
            'email.unique' => trans('validation.email_unique'),
        ];
    }
}
