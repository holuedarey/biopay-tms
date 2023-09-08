<?php

namespace App\Contracts;

use App\Helpers\Result;
use Illuminate\Support\Collection;

interface AirtimeServiceInterface extends BaseService
{
    /**
     * Make purchase for airtime.
     *
     * @param float $amount
     * @param string $phone
     * @param string $ref
     * @param string $service
     * @return Result
     */
    public function purchaseAirtime(float $amount, string $phone, string $ref, string $service): Result;
}
