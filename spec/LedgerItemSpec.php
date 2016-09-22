<?php

namespace spec\Dinero;

use PhpSpec\ObjectBehavior;

class LedgerItemSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedThrough('from', [1, 1000, null, 300.00, 55000, null, 'Some Item', '2016-02-03']);

        $this->voucherNumber()->shouldReturn(1);
        $this->accountNumber()->shouldReturn(1000);
        $this->accountVatCode()->shouldReturn(null);
        $this->amount()->shouldReturn(300.00);
        $this->balancingAccountNumber()->shouldReturn(55000);
        $this->balancingAccountVatCode()->shouldReturn(null);
        $this->description()->shouldReturn('Some Item');
        $this->voucherDate()->shouldReturn('2016-02-03');
    }
}
