<?php

namespace Dinero\Api;

class Ledger
{
    /**
     * @var DineroApiClient
     */
    private $client;

    /**
     * Ledger constructor.
     * @param DineroApiClient $client
     */
    public function __construct(DineroApiClient $client)
    {
        $this->client = $client;
    }

    public function addItems(array $ledgerItems)
    {
        $response = $this->client->post('/ledgeritems', $ledgerItems);

        return $response->getStatusCode() === 201 ? true : false;
    }
}
