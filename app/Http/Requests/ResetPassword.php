<?php

namespace App\Http\Requests;

use App\Rules\passwordVerify;
use Illuminate\Foundation\Http\FormRequest;

class ResetPassword extends FormRequest
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
            'o_password' => ['required', new passwordVerify($this->user())],
            'n_password' => 'required|min:8',
            '_password' => 'same:n_password',
        ];
    }
}
