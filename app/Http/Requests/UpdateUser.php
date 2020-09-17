<?php

namespace App\Http\Requests;

use App\Rules\fieldUnique;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

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
            'username' => ['required', 'min:4', new fieldUnique($this)],
            'email' => ['required', 'email', new fieldUnique($this)],
        ];
    }
}
