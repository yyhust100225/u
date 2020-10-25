<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * 要讯推送验证规则, 至少推送一个人
 * Class AtLeastOne
 * @package App\Rules
 */
class AtLeastOne implements Rule
{
    protected $request;
    protected $fields;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($request, $fields)
    {
        $this->request = $request;
        $this->fields = $fields;
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
        if(!is_null($value)) return true;
        foreach($this->fields as $field) {
            if(!is_null($this->request->get($field)))
                return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.at_least_one');
    }
}
