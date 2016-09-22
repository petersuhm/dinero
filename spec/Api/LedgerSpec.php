<?php

namespace spec\Dinero\Api;

use Dinero\Api\DineroApiClient;
use Dinero\Api\Ledger;
use Dinero\LedgerItem;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;

class LedgerSpec extends ObjectBehavior
{
    function let(DineroApiClient $client)
    {
        $this->beConstructedWith($client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Ledger::class);
    }

    function it_can_add_ledger_items(DineroApiClient $client, ResponseInterface $response)
    {
        $itemData = [
            [
                'VoucherNumber' => 1,
                'AccountNumber' => 1000,
                'AccountVatCode' => null,
                'Amount' => 300.00,
                'BalancingAccountNumber' => 55000,
                'BalancingAccountVatCode' => null,
                'Description' => 'Some Item',
                'VoucherDate' => '2016-02-03',
            ],
            [
                'VoucherNumber' => 2,
                'AccountNumber' => 1000,
                'AccountVatCode' => null,
                'Amount' => 200.00,
                'BalancingAccountNumber' => 55000,
                'BalancingAccountVatCode' => null,
                'Description' => 'Some Item',
                'VoucherDate' => '2016-02-03',
            ],
        ];

        $items = [
            $itemOne = LedgerItem::from(1, 1000, null, 300.00, 55000, null, 'Some Item', '2016-02-03'),
            $itemTwo = LedgerItem::from(2, 1000, null, 200.00, 55000, null, 'Some Item', '2016-02-03'),
        ];

        $response->getStatusCode()->willReturn(201);
        $client->post('/ledgeritems', $itemData)->willReturn($response);

        $this->addItems($items)->shouldReturn(true);
    }
}
