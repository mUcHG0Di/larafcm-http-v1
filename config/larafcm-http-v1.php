<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Push Notification Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default push notification driver that will be
    | used to send notifications. You may set this to any of the
    | drivers defined in the "drivers" array below.
    |
    */

    'default' => env('PUSH_NOTIFICATION_DRIVER', 'firebase'),

    /*
    |--------------------------------------------------------------------------
    | Push Notification Drivers
    |--------------------------------------------------------------------------
    |
    | Here you may configure the push notification drivers for your application.
    | Drivers added here will be available to use via the facade or manager.
    |
    */

    'drivers' => [
        'firebase' => [
            'driver' => 'firebase',
            'project_id' => env('FIREBASE_PROJECT_ID'),
            'credentials' => env('FIREBASE_CREDENTIALS', storage_path('app/fcm-credentials.json')),
            'scope' => env('FIREBASE_SCOPE', 'https://www.googleapis.com/auth/firebase.messaging'),
        ],
        // Add other drivers here as needed
    ],

    /*
    |--------------------------------------------------------------------------
    | Global Request Options
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default options for all push notification
    | requests. These can be overridden on a per-request basis.
    |
    */

    'default_options' => [
        'timeout' => env('PUSH_NOTIFICATION_TIMEOUT', 30),
        'priority' => env('PUSH_NOTIFICATION_PRIORITY', 'high'),
        'ttl' => env('PUSH_NOTIFICATION_TTL', 3600),
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Here you may specify rate limiting options to prevent overloading
    | the push notification service.
    |
    */

    'rate_limiting' => [
        'enabled' => env('PUSH_NOTIFICATION_RATE_LIMITING', true),
        'max_attempts' => env('PUSH_NOTIFICATION_MAX_ATTEMPTS', 5),
        'retry_after' => env('PUSH_NOTIFICATION_RETRY_AFTER', 100),
    ],

    /*
    |--------------------------------------------------------------------------
    | Logging
    |--------------------------------------------------------------------------
    |
    | Here you may configure logging options for push notifications.
    |
    */

    'logging' => [
        'enabled' => env('PUSH_NOTIFICATION_LOGGING', true),
        'channel' => env('PUSH_NOTIFICATION_LOG_CHANNEL', 'stack'),
    ],
];