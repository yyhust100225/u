<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Api
 * @method static string|array post(string $url, array $data, string $response_type = 'json', array $headers = [])
 * @package App\Facades
 */
class Api extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'api';
    }
}
