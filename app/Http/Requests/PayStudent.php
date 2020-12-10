<?php

namespace App\Http\Requests;

use App\Models\Student;
use App\Rules\StudentPay;
use Illuminate\Foundation\Http\FormRequest;

class PayStudent extends FormRequest
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
            'student_id' => ['required', 'integer'],
            'payment_type' => ['required', 'integer'],
            'payment_amount' => [new StudentPay(Student::with('payments')->find($this->input('student_id')), intval($this->input('payment_type')))],
        ];
    }
}
