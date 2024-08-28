
# larafcm-http-v1
Implementation of FCM http v1 for Laravel 5 (PHP 5.6)

## Table of Contents

* [Introduction](#introduction)
* [Installation](#installation)
* [Usage](#usage)
* [Configuration](#configuration)
* [License](#license)

## Introduction

This package provides an implementation of the Firebase Cloud Messaging (FCM) HTTP v1 protocol for Laravel 5 (PHP 5.6). It allows you to send push notifications to Android and iOS devices using the FCM service.

## Installation

To install the package, run the following command in your terminal:

```bash
composer require muchg0di/larafcm-http-v1
```

### Laravel

Register the provider directly in your app configuration file config/app.php config/app.php:

Laravel >= 5.5 provides package auto-discovery, thanks to rasmuscnielsen and luiztessadri who help to implement this feature in Laravel-FCM, the registration of the provider and the facades should not be necessary anymore.

```php
'providers' => [
	// ...
	Muchg0di\LarafcmHttpV1\LarafcmHttpV1ServiceProvider::class,
]
```

Add the facade aliases in the same file:

```php
'aliases' => [
	// ...
	'LarafcmHttpV1' => Muchg0di\LarafcmHttpV1\Facades\LarafcmHttpV1::class,
]
```

## Usage

To use the package, you can import the Facade `LarafcmHttpV1` call the `createFirebaseDriver` method to create a Firebase driver. Then, you can use the driver to send push notifications.

```php
use LarafcmHttpV1;
use Muchg0di\LarafcmHttpV1\DataTransferObjects\NotificationPayloadDto;
use Muchg0di\LarafcmHttpV1\DataTransferObjects\RequestOptionsDto;

$payload = new NotificationPayloadDto('Title', 'Body');
$options = new RequestOptionsDto(30); // timeout in seconds

LarafcmHttpV1::driver('firebase')
    ->sendToTopic('topic-name', $payload, $options);
```

## Configuration

You need to configure the package by publishing the configuration file and setting the FCM credentials.

```bash
php artisan vendor:publish --provider="Muchg0di\LarafcmHttpV1\LarafcmHttpV1ServiceProvider"
```

Then, update the `config/larafcm-http-v1.php` file with your FCM credentials.

```php
'drivers' => [
    'firebase' => [
        'driver' => 'firebase',
        'project_id' => env('FIREBASE_PROJECT_ID', 'your project id'),
        'credentials' => env('FIREBASE_CREDENTIALS', 'path/to/your/firebase-credentials.json'),
        'scope' => env('FIREBASE_SCOPE', 'your-firebase-scope'),
    ],
```

## Disclaimer
This is an implementation for a really old setup, so maybe if I find some time later, I will improve it.

## License

This package is licensed under the MIT License.
