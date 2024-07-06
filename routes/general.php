<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Agent;
use App\Http\Controllers\Api\DisputeController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;

use App\Http\Controllers\KycDocsApi;
use App\Http\Controllers\Ledger;
use App\Http\Controllers\ManageUserLevelApi;

use App\Http\Controllers\WebApi\Activities\ActivityLogController;
use App\Http\Controllers\WebApi\Approvals;
use App\Http\Controllers\WebApi\AssignUserRole;
use App\Http\Controllers\WebApi\Auth\AuthenticatedSessionController;
use App\Http\Controllers\WebApi\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\WebApi\Auth\NewPasswordController;
use App\Http\Controllers\WebApi\Auth\PasswordResetLinkController;
use App\Http\Controllers\WebApi\Dashboard;
use App\Http\Controllers\WebApi\Fees;
use App\Http\Controllers\WebApi\GeneralLedger\GeneralLedgers;
use App\Http\Controllers\WebApi\KycLevels;
use App\Http\Controllers\WebApi\Loans;
use App\Http\Controllers\WebApi\Menus;
use App\Http\Controllers\WebApi\Permissions;
use App\Http\Controllers\WebApi\Processors;
use App\Http\Controllers\WebApi\Providers;
use App\Http\Controllers\WebApi\Roles;
use App\Http\Controllers\WebApi\Routing;
use App\Http\Controllers\WebApi\Services;
use App\Http\Controllers\WebApi\Statistics;
use App\Http\Controllers\WebApi\TerminalGroups;
use App\Http\Controllers\WebApi\TerminalGroupTerminals;
use App\Http\Controllers\WebApi\TerminalMenus;
use App\Http\Controllers\WebApi\TerminalProcessors;
use App\Http\Controllers\WebApi\Terminals\Terminals;
use App\Http\Controllers\WebApi\Transactions;
use App\Http\Controllers\WebApi\UserKycDocs;
use App\Http\Controllers\WebApi\Users\Users;
use App\Http\Controllers\WebApi\Wallets;
use App\Http\Controllers\WebApi\WalletTransactions;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/auth')->middleware('guest')->group(function () {


    Route::post('login', [AuthenticatedSessionController::class, 'apiLogin']);
    Route::post('loginwithserial', [AuthenticatedSessionController::class, 'apiLoginWithterminalSerial']);

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.update');

});

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {

    Route::get('authtest/{user}', function (Request $request, $user){
        return $user;
    });

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [\App\Http\Controllers\WebApi\Auth\ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');

    Route::middleware(['auth:api', 'verified'])->group(function () {
        Route::get('/dashboard',                 [Dashboard::class, 'dashboardApi'])->name('dashboard');
        Route::get('statistics/{user?}',       [Statistics::class, 'statisticsApi'])->name('statistics');

        Route::prefix('manage-users')->group(function () {
            Route::controller(Admin::class)->prefix('admins')->name('admins.')->group(function () {
                Route::get('/', 'indexApi')->name('indexApi');
                Route::post('/register', 'createAdmin')->name('registerApi');
            });

            Route::controller(App\Http\Controllers\WebApi\Users\Users::class)->prefix('admins')->name('admins.')->group(function () {

                Route::post('/registers', 'storeApi')->name('registerApi');
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
            Route::get('/', 'indexApi')->name('indexApi');
            Route::get('/{activity}', 'showApi')->name('showApi');
        });

        Route::get('users/{user}',                  [Users::class, 'showApi']);
        Route::patch('users',                       [Users::class, 'updateApi']);
        Route::post('users',                        [Users::class, 'storeApi']);

        Route::resource('terminals',                    Terminals::class)->except(['destroy', 'edit', 'create']);
        Route::resource('users-kyc-docs',               UserKycDocs::class)->shallow()->only(['index', 'store']);
        Route::resource('users-manage-level',           ManageUserLevelApi::class)->only(['index', 'store']);
        Route::resource('kyc-docs',                     KycDocsApi::class)->shallow()->except(['edit', 'show']);
        Route::resource('transactions',                 Transactions::class)->only(['index', 'update']);
//        Route::resource('kyc-levels',                   KycLevels::class)->only(['index', 'store', 'update']);
        Route::post('kyc-levels', [KycLevels::class, 'store'])->name('kyc-levels.store');
        Route::put('kyc-levels/{kyc_level}', [KycLevels::class, 'update'])->name('kyc-levels.update');

        //this is only return a view
        Route::resource('ledger',                       Ledger::class)->only('index');
        //having authorization issue
        Route::resource('approvals',                    Approvals::class)->only(['index', 'update', 'destroy']);

        Route::resource('roles',                        Roles::class)->except(['edit', 'destroy']);

        Route::resource('permissions',                  Permissions::class)->only(['index', 'store', 'update']);

        Route::resource('roles.users',                  AssignUserRole::class)->only(['store', 'destroy']);


        Route::resource('services',                     Services::class)->only(['index', 'update']);

        Route::resource('terminal-groups',              TerminalGroups::class)->withoutMiddleware([VerifyCsrfToken::class]);

        Route::resource('terminal-groups.terminals',    TerminalGroupTerminals::class)->only('index','store');

        Route::resource('providers',                    Providers::class)->only(['index', 'store', 'destroy']);

        Route::resource('menus',                        Menus::class)->only('index');

        Route::resource('terminals.menus',              TerminalMenus::class)->only('store');

        Route::resource('wallets',                      Wallets::class)->only(['index', 'update']);

        Route::resource('wallet-transactions',          WalletTransactions::class)->only('index');

        Route::resource('processors',                   Processors::class)->only(['index', 'store', 'update']);


        Route::resource('terminal-processors',          TerminalProcessors::class)->only(['index', 'update']);

        Route::resource('routing',                      Routing::class)->only('index');

        Route::resource('loans',                        Loans::class)->only(['index', 'update']);

        Route::get('kyc-documents', [\App\Http\Controllers\WebApi\KycDocs::class, 'index'])->name('display');
        Route::get('/services/json', [Services::class, 'index'])->name('services.json');
        Route::get('/dispute', [DisputeController::class, 'store'])->name('dispute');


        Route::withoutMiddleware(VerifyCsrfToken::class)->group(function () {
            Route::resource('terminal-groups.fees', Fees::class)->only(['index', 'edit', 'update'])->shallow();

            Route::controller(Routing::class)->prefix('routing')->name('routing.')->group(function () {
                Route::get('/{routing}/settings', 'settings')->name('settings');

              //Not Clear
                Route::get('/settings/{type}/store', 'addSetting')->name('settings.add');
                Route::get('/settings/{type}/edit', 'addSetting')->name('settings.edit');
                Route::post('/settings/store', 'addSetting')->name('settings.store');
                Route::patch('/settings/update', 'updateSetting')->name('settings.update');
            });
        });
    });
});
