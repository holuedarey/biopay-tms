<?php

namespace App\Services;

use App\Contracts\TransferServiceInterface;
use App\Models\Service;

class Transfer
{
    /**
     * The slug of the service.
     */
    const NAME = 'banktransfer';

    /**
     * @throws \Throwable
     */
    public static function provider(): TransferServiceInterface
    {
        return Service::getActiveProviderFor(self::NAME, 'Transfer service');
    }
}
