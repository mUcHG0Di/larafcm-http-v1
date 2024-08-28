<?php

namespace Muchg0di\LarafcmHttpV1;

use Illuminate\Support\Manager;
use Muchg0di\LarafcmHttpV1\Clients\FirebaseClient;

class PushNotificationManager extends Manager
{
    protected $config;

    public function __construct($app)
    {
        parent::__construct($app);
        $this->config = $app['config']->get('larafcm-http-v1');
    }

    public function getDefaultDriver()
    {
        return $this->config['default'];
    }

    public function createFirebaseDriver()
    {
        $config = $this->config['drivers']['firebase'];
        return new FirebaseClient($config);
    }
}