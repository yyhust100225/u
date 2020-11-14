<?php

namespace App\Providers;

use App\Tools\Api;
use Illuminate\Support\ServiceProvider;

class RequestServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $api = new Api();

        $this->app->instance(Api::class, $api);
        $this->app->instance('api', $api);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
