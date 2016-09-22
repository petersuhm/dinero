<?php

namespace Dinero;

use GuzzleHttp\Client;

class DineroApiClient
{
    /**
     * @const string
     */
    const AUTH_URL = 'https://authz.dinero.dk/dineroapi/oauth/token';

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $clientId;

    /**
     * @var string
     */
    private $clientSecret;

    /**
     * @var Client
     */
    private $httpClient;

    /**
     * @var string
     */
    private $token;

    /**
     * DineroApiClient constructor.
     * @param Client $httpClient
     * @param $clientId
     * @param $clientSecret
     * @param $apiKey
     */
    public function __construct(Client $httpClient, $clientId, $clientSecret, $apiKey)
    {
        $this->httpClient = $httpClient;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->apiKey = $apiKey;
    }

    public function refreshToken()
    {
        $response = json_decode($this->httpClient->post($this::AUTH_URL, [
            'auth' => [$this->getClientId(), $this->getClientSecret()],
            'form_params' => [
                'grant_type' => 'password',
                'scope' => 'read write',
                'username' => $this->getApiKey(),
                'password' => $this->getApiKey(),
            ],
        ])->getBody()->getContents(), true);

        $this->token = $response['access_token'];
    }

    public function token()
    {
        return $this->token;
    }

    private function getClientId()
    {
        return $this->clientId;
    }

    private function getClientSecret()
    {
        return $this->clientSecret;
    }

    private function getApiKey()
    {
        return $this->apiKey;
    }
}
