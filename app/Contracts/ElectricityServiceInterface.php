<?php

namespace App\Contracts;

use App\Exceptions\FailedApiResponse;
use App\Helpers\Result;
use Illuminate\Support\Collection;

interface ElectricityServiceInterface extends BaseService
{
    /**
     * Get the distributors of the electricity service available by the provider
     *
     * @return Collection
     */
    public function distributors(): Collection;

    /**
     * Validate the meter number provided.
     *
     * @param string $meter The meter no to be validated
     * @param string $type <b>prepaid</b> or <b>postpaid</b>
     * @param string $code The distributor unique id
     * @param float $amount The amount to be paid
     * @return Collection
     * @throws FailedApiResponse
     */
    public function validateMeter(string $meter, string $code, string $type, float $amount): Collection;

    /**
     * Make purchase for electricity bill.
     *
     * @param float $amount
     * @param string $phone
     * @param string $ref
     * @param array $paymentData
     * @return Result
     */
    public function purchaseElectricity(float $amount, string $phone, string $ref, array $paymentData = []): Result;
}
