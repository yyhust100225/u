<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * 验证参数是否为正整数
 * Class UnsignedInteger
 * @package App\Rules
 */
class UnsignedInteger implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        return preg_match("/^[1-9][0-9]*$/", $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.verify_unsigned_integer');
    }
}
