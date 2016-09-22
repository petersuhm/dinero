<?php

namespace Dinero;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class DineroApiClient
{
    /**
     * @const string
     */
    const AUTH_URL = 'https://authz.dinero.dk/dineroapi/oauth/token';

    /**
     * @const string
     */
    const BASE_URL = 'https://api.dinero.dk/v1/';

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
     * @var string
     */
    private $orgId;

    /**
     * DineroApiClient constructor.
     * @param Client $httpClient
     * @param $clientId
     * @param $clientSecret
     * @param $apiKey
     * @param $orgId
     */
    public function __construct(Client $httpClient, $clientId, $clientSecret, $apiKey, $orgId)
    {
        $this->httpClient = $httpClient;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->apiKey = $apiKey;
        $this->orgId = $orgId;
    }

    /**
     * Obtain a fresh access token for the Dinero API.
     */
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

    /**
     * Post to the Dinero API.
     *
     * @param $uri
     * @param array $body
     * @return ResponseInterface
     */
    public function post($uri, array $body = [])
    {
        $url = $this::BASE_URL . $this->orgId . $uri;

        return $this->httpClient->post($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token()
            ],
            'json' => $body,
        ]);
    }

    /**
     * @return string
     */
    public function token()
    {
        return $this->token;
    }

    /**
     * @return string
     */
    private function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    private function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * @return string
     */
    private function getApiKey()
    {
        return $this->apiKey;
    }
}
