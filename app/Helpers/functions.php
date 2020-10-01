<?php

function route_uri($route_name)
{
    return app('router')->getRoutes()->getByName($route_name)->uri;
}

/**
 * 字符串转数组
 * @param string $str
 * @return int
 */
function string_to_integer(string $str)
{
    return intval($str);
}
