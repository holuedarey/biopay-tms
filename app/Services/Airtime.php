<?php

namespace App\Services;

use App\Contracts\AirtimeServiceInterface;
use App\Models\Service;

class Airtime
{

    const NAME = 'airtime';

    /**
     * @throws \Throwable
     */
    public static function provider(): AirtimeServiceInterface
    {
        return Service::getActiveProviderFor(self::NAME, 'Airtime purchase');
    }
}
