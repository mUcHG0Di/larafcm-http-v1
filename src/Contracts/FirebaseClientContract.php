<?php

namespace Muchg0di\LarafcmHttpV1\Contracts;

use Muchg0di\LarafcmHttpV1\DataTransferObjects\NotificationPayloadDto;
use Muchg0di\LarafcmHttpV1\DataTransferObjects\RequestOptionsDto;

interface FirebaseClientContract
{
    public function sendToToken($token, NotificationPayloadDto $payload, RequestOptionsDto $options);
    public function sendToTopic($topic, NotificationPayloadDto $payload, RequestOptionsDto $options);
    public function sendToCondition($condition, NotificationPayloadDto $payload, RequestOptionsDto $options);
    public function sendToMultipleTokens($tokens, NotificationPayloadDto $payload, RequestOptionsDto $options);
    public function getTopicSubscriptions($topic);
    public function subscribeToTopic($tokens, $topic);
    public function unsubscribeFromTopic($tokens, $topic);
}