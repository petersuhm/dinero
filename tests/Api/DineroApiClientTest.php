<?php

namespace tests\Api;

use Dinero\DineroApiClient;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\StreamInterface;

class DineroApiClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    function it_can_obtain_a_new_token()
    {
        $authUrl = 'https://authz.dinero.dk/dineroapi/oauth/token';
        $authParams = [
            'auth' => ['Client ID', 'ZyVpFUvnZch50j0OCfcjqCv2m1vvRofRSt3b40OkUQ'],
            'form_params' => [
                'grant_type' => 'password',
                'scope' => 'read write',
                'username' => '30a06f21929ddfe722e98f66e0f142a8',
                'password' => '30a06f21929ddfe722e98f66e0f142a8',
            ],
        ];

        $accessToken = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiIYcm46ZGluZXJvYXV0aHoiLCJhdWQiOiJodHRwOi8vYXBpLmRpbmVyby5kayIsIm5iZiI6MTQ3NDU0MDAwNywiZXhwIjoxNDc0NTQzNjA3LCJjbGllbnRfaWQiOiJXUHB1c2hlciIsInNjb3BlIjpbInJlYWQiLCJ3cml0ZSJdLCJhY2Nlc3NfbGV2ZWwiOiJDdXN0b21lciIsImh0dHA6Ly9kaW5lcm8uZGsvaWRlbnRpdHkvY2xhaW1zL3VzZXJwcm9maWxlaWQvIjoiNDlmYjQyZDM5MWI5NGZiMjg0MzdjNWVjM2E5YzFjNDgiLCJodHRwOi8vc2NoZW1hcy5taWNyb3NvZnQuY29tL3dzLzIwMDgvMDYvaWRlbnRpdHkvY2xhaW1zL2F1dGhlbnRpY2F0aW9ubWV0aG9kIjoiaHR0cDovL3NjaGVtYXMubWljcm9zb2Z0LmNvbS93cy8yMDA4LzA2L2lkZW50aXR5L2F1dGhlbnRpY2F0aW9ubWV0aG9kL3Bhc3N3b3JkIiwiaHR0cDovL3NjaGVtYXMubWljcm9zb2Z0LmNvbS93cy8yMDA4LzA2L2lkZW50aXR5L2NsYWltcy9hdXRoZW50aWNhdGlvbmluc3RhbnQiOiIyMDE2LTA5LTIyVDEwOjI2OjQ2LjcyNVoifQ.GFNsK1Uf_xLr6qoeab9BWg0Ux9ARpZenGiPivIk4IfE";

        $body = \Mockery::mock(StreamInterface::class);
        $body->shouldReceive('getContents')->andReturn(json_encode([
            'access_token' => $accessToken,
            'token_type' => 'Bearer',
            'expires_in' => 3600,
            'refresh_token' => null
        ]));

        $response = \Mockery::mock(Response::class);
        $response->shouldReceive('getStatusCode')->andReturn(200);
        $response->shouldReceive('getBody')->andReturn($body);

        $httpClient = \Mockery::mock(Client::class);
        $httpClient->shouldReceive('post')->with($authUrl, $authParams)->andReturn($response);

        $client = new DineroApiClient(
            $httpClient,
            'Client ID',
            'ZyVpFUvnZch50j0OCfcjqCv2m1vvRofRSt3b40OkUQ',
            '30a06f21929ddfe722e98f66e0f142a8'
        );

        $client->refreshToken();

        $this->assertEquals($accessToken, $client->token());
    }
}
