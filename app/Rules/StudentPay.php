<?php

namespace App\Rules;

use App\Models\Student;
use Illuminate\Contracts\Validation\Rule;

class StudentPay implements Rule
{
    private $student;
    private $payment_type;
    private $message;

    /**
     * Create a new rule instance.
     *
     * @param Student $student
     * @param integer $payment_type
     */
    public function __construct(Student $student, int $payment_type)
    {
        $this->student = $student;
        $this->payment_type = $payment_type;
        $this->message = 0;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $total_amount = array_sum($value);
        $already_paid_amount = array_sum($this->student->payments->pluck('total_amount')->toArray());
        // 无效缴费金额
        if($total_amount <= 0.00) {
            $this->message = 1;
        }
        // 缴费超额
        else if(bcadd($total_amount, $already_paid_amount, 2) > $this->student->paid_amount) {
            $this->message = 5;
        }
        // 分情况判断
        else {
            switch ($this->payment_type) {
                case PAYMENT_TYPE_FULL:{
                    if (!$this->student->payments->isEmpty())
                        $this->message = 2;
                    else if ($total_amount < $this->student->paid_amount)
                        $this->message = 3;
                }break;
                case PAYMENT_TYPE_SUPPLEMENT:{
                    if (bcadd($total_amount, $already_paid_amount, 2) != $this->student->paid_amount)
                        $this->message = 4;
                }break;
                default:break;
            }
        }

        return $this->message === 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        switch($this->message){
            case 1: return trans('validation.attributes.pay.pay_invalid_amount');
            case 2: return trans('validation.attributes.pay.pay_has_record');
            case 3: return trans('validation.attributes.pay.pay_no_full');
            case 4: return trans('validation.attributes.pay.pay_rest');
            case 5: return trans('validation.attributes.pay.pay_over_required');
        }
    }
}
