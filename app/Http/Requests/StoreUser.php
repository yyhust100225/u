<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StoreUser extends FormRequest
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
            'username' => ['required', 'min:2', Rule::unique('users')],
            'email' => ['required', 'email', Rule::unique('users')],
            'password' => 'required|min:8',
            '_password' => 'same:password',
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
