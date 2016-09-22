<?php

namespace Dinero;

class LedgerItem
{
    /**
     * @var
     */
    private $voucherNumber;

    /**
     * @var
     */
    private $accountNumber;

    /**
     * @var
     */
    private $accountVatCode;

    /**
     * @var
     */
    private $amount;

    /**
     * @var
     */
    private $balancingAccountNumber;

    /**
     * @var
     */
    private $balancingAccountVatCode;

    /**
     * @var
     */
    private $description;

    /**
     * @var
     */
    private $voucherDate;

    private function __construct()
    {
        //
    }

    /**
     * @param $voucherNumber
     * @param $accountNumber
     * @param $accountVatCode
     * @param $amount
     * @param $balancingAccountNumber
     * @param $balancingAccountVatCode
     * @param $description
     * @param $voucherDate
     * @return LedgerItem
     */
    public static function from($voucherNumber, $accountNumber, $accountVatCode, $amount, $balancingAccountNumber, $balancingAccountVatCode, $description, $voucherDate)
    {
        $ledgerItem = new LedgerItem();

        $ledgerItem->voucherNumber = $voucherNumber;
        $ledgerItem->accountNumber = $accountNumber;
        $ledgerItem->accountVatCode = $accountVatCode;
        $ledgerItem->amount = $amount;
        $ledgerItem->balancingAccountNumber = $balancingAccountNumber;
        $ledgerItem->balancingAccountVatCode = $balancingAccountVatCode;
        $ledgerItem->description = $description;
        $ledgerItem->voucherDate = $voucherDate;

        return $ledgerItem;
    }

    public function voucherNumber()
    {
        return $this->voucherNumber;
    }

    public function accountNumber()
    {
        return $this->accountNumber;
    }

    public function accountVatCode()
    {
        return $this->accountVatCode;
    }

    public function amount()
    {
        return $this->amount;
    }

    public function balancingAccountNumber()
    {
        return $this->balancingAccountNumber;
    }

    public function balancingAccountVatCode()
    {
        return $this->balancingAccountVatCode;
    }

    public function description()
    {
        return $this->description;
    }

    public function voucherDate()
    {
        return $this->voucherDate;
    }
}
