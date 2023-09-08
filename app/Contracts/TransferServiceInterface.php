<?php


namespace App\Contracts;


use App\Helpers\Result;

interface TransferServiceInterface extends BaseService
{
    /**
     * Update Bank list.
     *
     * @return Result
     */
    public function updateBankList() : Result;


    /**
     * Validate bank account
     *
     * @param $code string Bank code
     * @param $accountNumber string Bank account number
     *
     * @return Result
     */
    public function validateAccount(string $code, string $accountNumber) : Result;


    /**
     * Transfer funds to commercial bank
     *
     * @param string $code
     * @param string $accountNumber
     * @param float $amount
     * @param string $narration
     * @param string $reference
     * @param string|null $bank
     * @param string|null $accountName
     * @return Result
     */
    public function transfer(string $code, string $accountNumber, float $amount, string $narration, string $reference, string $bank = null, string $accountName = null) : Result;
}
