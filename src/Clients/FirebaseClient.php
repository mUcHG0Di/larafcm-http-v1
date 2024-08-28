<?php

namespace Muchg0di\LarafcmHttpV1\Clients;

use Muchg0di\LarafcmHttpV1\Contracts\FirebaseClientContract;
use Muchg0di\LarafcmHttpV1\DataTransferObjects\NotificationPayloadDto;
use Muchg0di\LarafcmHttpV1\DataTransferObjects\RequestOptionsDto;
use Muchg0di\LarafcmHttpV1\Services\MessageBuilder;
use Muchg0di\LarafcmHttpV1\Services\FirebaseApiClient;

class FirebaseClient implements FirebaseClientContract
{
    protected $messageBuilder;
    protected $apiClient;
    protected $httpClient;

    public function __construct(array $config)
    {
        $this->messageBuilder = new MessageBuilder();
        $this->apiClient = new FirebaseApiClient($config);
    }

    public function setHttpClient($client)
    {
        $this->httpClient = $client;
    }

    public function sendToToken($token, NotificationPayloadDto $payload, RequestOptionsDto $options)
    {
        $message = $this->messageBuilder->buildMessage(['token' => $token], $payload, $options);

        return $this->apiClient->sendMessage($message, $options);
    }

    public function sendToTopic($topic, NotificationPayloadDto $payload, RequestOptionsDto $options)
    {
        $message = $this->messageBuilder->buildMessage(['topic' => $topic], $payload, $options);

        return $this->apiClient->sendMessage($message, $options);
    }

    public function sendToCondition($condition, NotificationPayloadDto $payload, RequestOptionsDto $options)
    {
        $message = $this->messageBuilder->buildMessage(['condition' => $condition], $payload, $options);

        return $this->apiClient->sendMessage($message, $options);
    }

    public function sendToMultipleTokens($tokens, NotificationPayloadDto $payload, RequestOptionsDto $options)
    {
        $responses = [];
        
        foreach (array_chunk($tokens, 500) as $tokenChunk) {
            $message = $this->messageBuilder->buildMessage(['token' => $tokenChunk], $payload, $options);
            $responses[] = $this->apiClient->sendMessage($message, $options);
        }

        return $responses;
    }

    public function getTopicSubscriptions($topic)
    {
        return $this->apiClient->getTopicSubscriptions($topic);
    }

    public function subscribeToTopic($tokens, $topic)
    {
        return $this->apiClient->subscribeToTopic($tokens, $topic);
    }

    public function unsubscribeFromTopic($tokens, $topic)
    {
        return $this->apiClient->unsubscribeFromTopic($tokens, $topic);
    }
}