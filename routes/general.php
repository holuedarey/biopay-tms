<?php

use App\Http\Controllers\Api\DisputeController;
use App\Http\Controllers\Api\Loans;
use App\Http\Controllers\Api\Services;
use App\Http\Controllers\Api\Wallets;
use App\Http\Controllers\Api\WalletTransactions;
use App\Http\Controllers\Approvals;
use App\Http\Controllers\AssignUserRole;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Fees;
use App\Http\Controllers\KycLevels;
use App\Http\Controllers\Ledger;
use App\Http\Controllers\Menus;
use App\Http\Controllers\Permissions;
use App\Http\Controllers\Processors;
use App\Http\Controllers\Providers;
use App\Http\Controllers\Roles;
use App\Http\Controllers\Routing;
use App\Http\Controllers\TerminalGroups;
use App\Http\Controllers\TerminalGroupTerminals;
use App\Http\Controllers\TerminalMenus;
use App\Http\Controllers\TerminalProcessors;
use App\Http\Controllers\TerminalsApi;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Agent;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Statistics;
use App\Http\Controllers\GeneralLedgers;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Users;
use App\Http\Controllers\Terminals;
use App\Http\Controllers\UserKycDocs;
use App\Http\Controllers\ManageUserLevel;
use App\Http\Controllers\KycDocs;
use App\Http\Controllers\Transactions;
use App\Models\Role;

Route::prefix('v1/auth')->middleware('guest')->group(function () {


    Route::post('login', [AuthenticatedSessionController::class, 'apiLogin']);

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.update');

});

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {

    Route::get('authtest', function (){
        return "Authenticated";
    });

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/dashboard',                 [Dashboard::class, 'dashboardApi'])->name('dashboard');
        Route::get('statistics/{user?}',       [Statistics::class, 'statisticsApi'])->name('statistics');

        Route::prefix('manage-users')->group(function () {
            Route::controller(Admin::class)->prefix('admins')->name('admins.')->group(function () {
                Route::get('/', 'indexApi')->name('indexApi');
                Route::post('/register', 'createAdmin')->name('registerApi');
            });

            Route::controller(Agent::class)->name('agents.')->group(function () {
                Route::get('agents', 'indexApi')->name('index');
                Route::post('onboard', 'createAdmin')->name('onboardApi');
            });

            Route::controller(Agent::class)->name('super-agents.')->group(function () {
                Route::get('super-agents', 'indexApi')->name('index');
            });
        });

        Route::controller(GeneralLedgers::class)->prefix('general-ledger')->name('general-ledger.')->group(function () {
            Route::get('/', 'showApi')->name('showApi');
            Route::get('/others', 'indexApi')->name('others');
            Route::post('/{gl}/update', 'updateApi')->name('update');
        });

        Route::controller(ActivityLogController::class)->prefix('activities')->name('activities.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{activity}', 'show')->name('show');
        });

        Route::resource('users',                        Users::class)->only(['show', 'update', 'store']);
        Route::resource('terminals',                    TerminalsApi::class)->except(['destroy', 'edit', 'create']);
        Route::resource('users.kyc-docs',               UserKycDocs::class)->shallow()->only(['indexApi', 'storeApi']);
        Route::resource('users.manage-level',           ManageUserLevel::class)->only(['indexApi', 'storeApi']);
        Route::resource('kyc-docs',                     KycDocs::class)->shallow()->except(['edit', 'show']);
        Route::resource('transactions',                 Transactions::class)->only(['index', 'update']);
        Route::resource('kyc-levels',                   KycLevels::class)->only(['index', 'store', 'update']);
        Route::resource('ledger',                       Ledger::class)->only('index');
        Route::resource('approvals',                    Approvals::class)->only(['index', 'update', 'destroy']);
        Route::resource('roles',                        Roles::class)->except(['edit', 'destroy']);
        Route::resource('permissions',                  Permissions::class)->only(['index', 'store', 'update']);
        Route::resource('roles.users',                  AssignUserRole::class)->only(['store', 'destroy']);
        Route::resource('services',                     Services::class)->only(['index', 'update']);
        Route::resource('terminal-groups',              TerminalGroups::class)->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        Route::resource('terminal-groups.terminals',    TerminalGroupTerminals::class)->only('index');
        Route::resource('providers',                    Providers::class)->only(['index', 'store', 'destroy']);
        Route::resource('menus',                        Menus::class)->only('index');
        Route::resource('terminals.menus',              TerminalMenus::class)->only('store');
        Route::resource('wallets',                      Wallets::class)->only(['index', 'update']);
        Route::resource('wallet-transactions',          WalletTransactions::class)->only('index');
        Route::resource('processors',                   Processors::class)->only(['index', 'store', 'update']);
        Route::resource('terminal-processors',          TerminalProcessors::class)->only(['index', 'update']);
        Route::resource('routing',                      Routing::class)->only('index');
        Route::resource('loans',                        Loans::class)->only(['index', 'update']);

        Route::get('kyc-documents', [KycDocs::class, 'display'])->name('display');
        Route::get('/services/json', [Services::class, 'jsonData'])->name('services.json');
        Route::get('/dispute', [DisputeController::class, 'index'])->name('dispute');


        Route::withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)->group(function () {
            Route::resource('terminal-groups.fees', Fees::class)->only(['index', 'edit', 'update'])->shallow();

            Route::controller(Routing::class)->prefix('routing')->name('routing.')->group(function () {
                Route::get('/{routing}/settings', 'settings')->name('settings');
                Route::get('/settings/{type}/store', 'addSetting')->name('settings.add');
                Route::get('/settings/{type}/edit', 'addSetting')->name('settings.edit');
                Route::post('/settings/store', 'addSetting')->name('settings.store');
                Route::patch('/settings/update', 'updateSetting')->name('settings.update');
            });
        });
    });
});
