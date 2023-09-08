<?php

// Declare functions that would be used globally throughout the application.
use App\Enums\Action;
use App\Enums\Status;
use App\Models\Service;

/**
 * get the color value for a given status.
 * @param string|Status|Action $value
 * @return string
 */
function statusColor(string|Status|Action $value): string
{
    return match ($value) {
        Status::PENDING, 'SUSPENDED', 'CHARGE' => 'yellow',

        Status::CONFIRMED, Status::APPROVED, Status::SUCCESSFUL,
        Action::CREDIT, 'FUNDED', 'CREDITED', 'SUCCESS', 'ACTIVE' => 'green',

        Status::DECLINED, Status::FAILED, Action::DEBIT, 'DEBITED', 'INACTIVE', 'DISABLED' => 'red',

        default  => 'blue',
    };
}


/**
 * Convert to human-readable format with country's currency
 *
 * @param float|null $value
 * @param string $symbol
 * @return string
 */
function moneyFormat(float|null $value, string $symbol = '₦'): string
{
    $value ??= 0;

    return str(number_format ($value, 2, ))->whenContains('-',
        fn($value) => $value->replace('-', "- $symbol"),
        fn($value) => $value->prepend($symbol),
    );
}


/**
 * Get the app logo from the env
 * @return object
 */
function appLogo(): object
{
    return Cache::rememberForever('app_logo', function () {
        if ($val = config('app.logo')) {
            return (object) ['image' => true, 'value' => $val];
        } else {
            return (object) ['image' => false, 'value' => getenv('APP_NAME')];
        }
    });
}

/**
 * Get the app logo from the env
 * @return object
 */
function appLogo2(): object
{
    return Cache::rememberForever('app_logo_2', function () {
        $val = config('app.logo2');

        return $val ? (object) ['image' => true, 'value' => $val] : appLogo();
    });
}
