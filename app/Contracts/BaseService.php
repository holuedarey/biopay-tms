<?php

namespace App\Contracts;

interface BaseService
{
    /**
     * Service provider name
     * @return string
     */
    public static function name(): string;
}
