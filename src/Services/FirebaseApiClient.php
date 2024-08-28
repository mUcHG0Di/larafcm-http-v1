<?php

namespace Muchg0di\LarafcmHttpV1\Services;

use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Auth\Middleware\AuthTokenMiddleware;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Muchg0di\LarafcmHttpV1\DataTransferObjects\RequestOptionsDto;
use Muchg0di\LarafcmHttpV1\Exceptions\FirebaseException;
use InvalidArgumentException;

class FirebaseApiClient
{
    const METHOD_POST = 'post';
    const METHOD_GET = 'get';

    protected $httpClient;
    protected $credentials;
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->credentials = $this->createServiceAccountCredentials();
        $projectId = $config['project_id'];
        
        $middleware = new AuthTokenMiddleware($this->credentials);
        $stack = HandlerStack::create();
        $stack->push($middleware);
        
        $this->httpClient = new Client([
            'handler' => $stack,
            'timeout' => 30,
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'base_uri' => "https://fcm.googleapis.com/v1/projects/$projectId/",
            'auth' => 'google_auth'
        ]);
    }

    protected function getHeaders($contentType = null)
    {
        $headers = [
            'Authorization' => 'Bearer ' . $this->credentials->fetchAuthToken()['access_token'],
        ];

        if ($contentType) {
            $headers['Content-Type'] = $contentType;
        }

        return $headers;
    }

    protected function makeRequest($method, $endpoint, $options = [])
    {
        try {
            $response = $this->httpClient->$method($endpoint, $options);

            return $response; //json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            throw new FirebaseException("Failed to {$method} '{$endpoint}': " . $e->getMessage(), $e->getCode(), $e);
        }
    }

    public function sendMessage(array $message, RequestOptionsDto $options)
    {
        $requestOptions = [
            'headers' => $this->getHeaders('application/json'),
            'json' => $message,
            'timeout' => $options->getTimeout(),
        ];

        return $this->makeRequest(self::METHOD_POST, 'messages:send', $requestOptions);
    }

    public function getTopicSubscriptions($topic)
    {
        $requestOptions = [
            'headers' => $this->getHeaders(),
        ];

        return $this->makeRequest(self::METHOD_GET, "topics/{$topic}", $requestOptions);
    }

    public function subscribeToTopic($tokens, $topic)
    {
        return $this->topicOperation($tokens, $topic, 'iid/v1:batchAdd');
    }

    public function unsubscribeFromTopic($tokens, $topic)
    {
        return $this->topicOperation($tokens, $topic, 'iid/v1:batchRemove');
    }

    protected function topicOperation($tokens, $topic, $endpoint)
    {
        $requestOptions = [
            'headers' => $this->getHeaders('application/json'),
            'json' => [
                'to' => '/topics/' . $topic,
                'registration_tokens' => $tokens,
            ],
        ];

        return $this->makeRequest(self::METHOD_POST, $endpoint, $requestOptions);
    }

    private function createServiceAccountCredentials()
    {
        $credentialsPath = $this->config['credentials'];
        if (! $credentialsPath) {
            throw new InvalidArgumentException('Google Auth credentials path is not set in the FCM configuration.');
        }

        $scope = $this->config['scope'];
        if (! $scope) {
            $scope = 'https://www.googleapis.com/auth/firebase.messaging';
        }

        return new ServiceAccountCredentials($scope, $credentialsPath);
    }
}