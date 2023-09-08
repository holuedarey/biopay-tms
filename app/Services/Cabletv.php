<?php

namespace App\Services;

use App\Contracts\AirtimeServiceInterface;
use App\Contracts\CableTvServiceInterface;
use App\Models\Service;

class Cabletv
{

    const NAME = 'cabletv';

    /**
     * @throws \Throwable
     */
    public static function provider(): CableTvServiceInterface
    {
        return Service::getActiveProviderFor(self::NAME, 'Cable-Tv purchase');
    }
}
