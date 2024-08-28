<?php

namespace Muchg0di\LarafcmHttpV1\Services;

use Muchg0di\LarafcmHttpV1\DataTransferObjects\NotificationPayloadDto;
use Muchg0di\LarafcmHttpV1\DataTransferObjects\RequestOptionsDto;

class MessageBuilder
{
    public function buildMessage(array $target, NotificationPayloadDto $payload, RequestOptionsDto $options)
    {
        $message = [
            'message' => array_merge($target, [
                'notification' => $payload->toArray(),
            ])
        ];

        if ($options->getPriority()) {
            $message['message']['android']['priority'] = $options->getPriority();
            $message['message']['apns']['headers']['apns-priority'] = $options->getPriority() === 'high' ? '10' : '5';
        }

        if ($options->getTtl()) {
            $message['message']['android']['ttl'] = $options->getTtl() . 's';
            $message['message']['apns']['headers']['apns-expiration'] = time() + $options->getTtl();
        }

        if ($options->getCollapseKey()) {
            $message['message']['android']['collapse_key'] = $options->getCollapseKey();
            $message['message']['apns']['headers']['apns-collapse-id'] = $options->getCollapseKey();
        }

        return $message;
    }
}