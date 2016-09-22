<?php

namespace Dinero\Api;

use Dinero\LedgerItem;

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
        $itemData = array_reduce($ledgerItems, function($itemData, LedgerItem $item) {
            $itemData[] = [
                'VoucherNumber' => $item->voucherNumber(),
                'AccountNumber' => $item->accountNumber(),
                'AccountVatCode' => $item->accountVatCode(),
                'Amount' => $item->amount(),
                'BalancingAccountNumber' => $item->balancingAccountNumber(),
                'BalancingAccountVatCode' => $item->balancingAccountVatCode(),
                'Description' => $item->description(),
                'VoucherDate' => $item->voucherDate(),
            ];

            return $itemData;
        }, $itemData = []);

        $response = $this->client->post('/ledgeritems', $itemData);

        return $response->getStatusCode() === 201 ? true : false;
    }
}
