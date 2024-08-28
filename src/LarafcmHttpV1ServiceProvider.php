<?php

namespace Muchg0di\LarafcmHttpV1;

use Illuminate\Support\ServiceProvider;
use Muchg0di\LarafcmHttpV1\PushNotificationManager;

class LarafcmHttpV1ServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/larafcm-http-v1.php' => config_path('larafcm-http-v1.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/larafcm-http-v1.php', 'larafcm-http-v1');

        $this->app->singleton('larafcm-http-v1', function ($app) {
            return new PushNotificationManager($app);
        });
    }
}