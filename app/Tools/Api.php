<?php

namespace App\Tools;

use Ixudra\Curl\Facades\Curl;
use stdClass;

class Api
{
    public function __construct()
    {

    }

    /**
     * 对接API POST请求
     * @param $url
     * @param $data
     * @param string $response_type
     * @param array $headers
     * @return array|mixed|stdClass
     */
    public function post($url, $data, $response_type = 'json', $headers = [])
    {
        $response = Curl::to($url)
            ->withData($data)
            ->withHeaders($headers)
            ->post();

        switch(strtolower($response_type)) {
            case 'json': return json_decode($response, true);
            default: return $response;
        }
    }
}
