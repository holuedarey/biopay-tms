<?php

namespace App\Services;

use App\Contracts\AirtimeServiceInterface;
use App\Contracts\DataServiceInterface;
use App\Models\Service;

class Data
{

    const NAME = 'internetdata';

    /**
     * @throws \Throwable
     */
    public static function provider(): DataServiceInterface
    {
        return Service::getActiveProviderFor(self::NAME, 'Data purchase');
    }
}
