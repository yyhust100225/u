<?php

function route_uri($route_name)
{
    return app('router')->getRoutes()->getByName($route_name)->uri;
}
