<?php

namespace App\Contracts;

use App\Exceptions\FailedApiResponse;
use App\Helpers\Result;
use Illuminate\Support\Collection;

interface DataServiceInterface extends BaseService
{
    /**
     * @param string $network
     * @return Collection
     * @throws FailedApiResponse
     */
    public function getDataPlans(string $network): Collection;

    /**
     * @param string $phone
     * @param string $code The unique code for the data plan as given by the provider.s
     * @param float $amount
     * @param string $network
     * @param string $ref
     * @param mixed $meta  Extra data required by the provider for the request.
     * @return Result
     */
    public function purchaseData(string $phone, string $code, float $amount, string $network, string $ref, $meta): Result;
}
