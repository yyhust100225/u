<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'username' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8',
            '_password' => 'same:password',
        ];
    }

    public function attributes()
    {
        return [
            'username' => '用户名称',
            'password' => '密码',
            '_password' => '密码确认',
            'email' => '邮箱',
        ];
    }
}
