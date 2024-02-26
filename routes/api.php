<?php

use App\Http\Controllers\Api\AddBvn;
use App\Http\Controllers\Api\AirtimePurchase;
use App\Http\Controllers\Api\Authenticate;
use App\Http\Controllers\Api\Banks;
use App\Http\Controllers\Api\CableTvPurchase;
use App\Http\Controllers\Api\Dashboard;
use App\Http\Controllers\Api\DataPurchase;
use App\Http\Controllers\Api\ElectricityPurchase;
use App\Http\Controllers\Api\KycDocs;
use App\Http\Controllers\Api\Levels;
use App\Http\Controllers\Api\Loans;
use App\Http\Controllers\Api\Logout;
use App\Http\Controllers\Api\PasswordResetLink;
use App\Http\Controllers\Api\Profile;
use App\Http\Controllers\Api\Register;
use App\Http\Controllers\Api\Services;
use App\Http\Controllers\Api\Terminals;
use App\Http\Controllers\Api\Transactions;
use App\Http\Controllers\Api\Transfer;
use App\Http\Controllers\Api\Wallets;
use App\Http\Controllers\Api\WalletTransactions;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DisputeController;

Route::prefix('v1')->middleware('decode')->group(function () {

    Route::post('register',             Register::class);
    Route::post('forgot-password',      PasswordResetLink::class);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('dashboard', Dashboard::class);

        Route::apiResource('terminals',                 Terminals::class)->only('update');
        Route::apiResource('profile',                   Profile::class)->only(['index', 'store']);
        Route::apiResource('services',                  Services::class)->only('index');
        Route::apiResource('kyc-docs',                  KycDocs::class)->only('store', 'destroy');
        Route::apiResource('wallets',                   Wallets::class)->only('index');
        Route::apiResource('transactions',              Transactions::class)->only(['index', 'show']);
        Route::apiResource('wallet-transactions',       WalletTransactions::class)->only('index');
        Route::apiResource('banks',                     Banks::class)->only(['index']);
        Route::apiResource('loans',                     Loans::class)->only(['index', 'store', 'update', 'destroy']);
        Route::apiResource('levels',                    Levels::class)->only('index');

        Route::apiResource('validate-transfer',         Transfer::class)->only('index');
        Route::apiResource('transfer',                  Transfer::class)->only('store');

        Route::apiResource('airtime-services',          AirtimePurchase::class)->only('index');
        Route::apiResource('airtime-purchase',          AirtimePurchase::class)->only('store');

        Route::apiResource('data-plans',                DataPurchase::class)->only('index');
        Route::apiResource('data-purchase',             DataPurchase::class)->only('store');

        Route::apiResource('dispute',                   DisputeController::class)->only( 'store');

        Route::post('cabletv/plans',             [CableTvPurchase::class, 'plans']);
        Route::post('cabletv/validate',          [CableTvPurchase::class, 'validateAccount']);
        Route::post('cabletv/purchase',          [CableTvPurchase::class, 'purchase']);

        Route::get('electricity/distributors',  [ElectricityPurchase::class, 'distributors']);
        Route::post('electricity/validate-meter',            [ElectricityPurchase::class, 'validateMeter']);
        Route::post('electricity/purchase',      [ElectricityPurchase::class, 'purchase']);

        Route::get('levels/add-bvn',           AddBvn::class);

        Route::get('logout',    Logout::class);
    });
});

require __DIR__.'/general.php';

