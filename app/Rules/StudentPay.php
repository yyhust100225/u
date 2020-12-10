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

        switch($this->payment_type){
            case PAYMENT_TYPE_FULL: {
                if(!$this->student->payments->isEmpty())
                    $this->message = 1;
                else if($total_amount < $this->student->paid_amount)
                    $this->message = 2;
            }break;
            case PAYMENT_TYPE_SUPPLEMENT: {
                if(bcadd($total_amount, $already_paid_amount, 2) != $this->student->paid_amount)
                    $this->message = 3;
            }break;
            default: {
                if(bcadd($total_amount, $already_paid_amount, 2) > $this->student->paid_amount)
                    $this->message = 4;
            }break;
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
            case 1: return '该学生已有交款记录, 这笔缴费无法为全款';
            case 2: return '全款请一次性付清, 此次缴费金额不足';
            case 3: return '补缴请缴纳完成剩余款项';
            case 4: return '此次缴费金额超出实缴金额';
        }
        return 'The validation error message.';
    }
}
