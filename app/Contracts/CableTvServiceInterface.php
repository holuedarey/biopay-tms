<?php

namespace App\Contracts;

use App\Exceptions\FailedApiResponse;
use App\Helpers\Result;
use Illuminate\Support\Collection;

interface CableTvServiceInterface extends BaseService
{
    /**
     * Get plans for available for the decoder type.
     *
     * @param string $decoder
     * @return Collection
     * @throws FailedApiResponse
     */
    public function getCablePlans(string $decoder): Collection;

    /**
     *
     * @param string $decoder
     * @param string $uniqueId
     * @param string|null $type
     * @return Collection
     * @throws FailedApiResponse
     *
     */
    public function validateCablePlan(string $decoder, string $uniqueId, string $type = null): Collection;

    /**
     * @param string $decoder The decoder type like <b>dstv</b>, <b>gotv</b>, etc...
     * @param string $planCode The code for the bouquet plan to be purchased
     * @param string $phone The phone number of the recipient
     * @param float $amount The amount of the cable plan
     * @param string $ref The reference of the transaction
     * @param int|null $months The months of the subscription
     * @param array $paymentData Extra payment data from previous validation that would be required for the purchase.
     * @return Result
     */
    public function purchaseCablePlan(string $decoder, string $planCode, string $phone, float $amount, string $ref, ?int $months = 1, array $paymentData = []): Result;
}
