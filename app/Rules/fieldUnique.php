<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

/**
 * 表单验证规则 -- 字段唯一
 * Class fieldUnique
 * @package App\Rules
 */
class fieldUnique implements Rule
{
    protected $attribute;
    protected $primary_id;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        if($request->has('id')) {
            $this->primary_id = $request->input('id');
        } else {
            $this->primary_id = null;
        }
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
        $this->attribute = $attribute;

        if(is_null($this->primary_id))
            return User::withTrashed()->where($attribute, $value)->doesntExist();
        else
            return User::withTrashed()->where($attribute, $value)->where('id', '<>', $this->primary_id)->doesntExist();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.' . $this->attribute . '_unique');
    }
}
