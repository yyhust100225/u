<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\TransformsRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

class FilterMiddleware extends TransformsRequest
{
    /**
     * 配置需要自动加p标签的字段
     * @var array
     */
    protected $auto_paragraph_keys = [
        'content',
    ];

    /**
     * 过滤输入标签
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    protected function transform($key, $value)
    {
        if(in_array($key, $this->auto_paragraph_keys))
            return clean($value, 'auto_paragraph');
        else
            return clean($value);
    }
}
