<?php

namespace App\Services;

use App\Contracts\ElectricityServiceInterface;
use App\Models\Service;

class Electricity
{

    const NAME = 'electricity';

    /**
     * @throws \Throwable
     */
    public static function provider(): ElectricityServiceInterface
    {
        return Service::getActiveProviderFor(self::NAME, 'Electricity service');
    }
}
