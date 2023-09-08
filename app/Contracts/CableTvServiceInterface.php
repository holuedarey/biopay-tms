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

    public function purchaseCablePlan(string $decoder, string $planCode, string $phone, float $amount, string $ref, int $months = 1, array $paymentData = []): Result;
}
