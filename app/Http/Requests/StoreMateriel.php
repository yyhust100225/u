<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMateriel extends FormRequest
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
            'quantity_total' => ['numeric'],
            'quantity_scrap' => ['numeric'],
            'quantity_consume' => ['numeric'],
            'quantity_incomplete' => ['numeric'],
        ];
    }

    public function attributes()
    {
        return [
            'name' => trans('validation.attributes.materiel_name'),
        ];
    }
}
