<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Agent;
use App\Http\Controllers\Approvals;
use App\Http\Controllers\AssignUserRole;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Fees;
use App\Http\Controllers\GeneralLedgers;
use App\Http\Controllers\KycDocs;
use App\Http\Controllers\KycLevels;
use App\Http\Controllers\Ledger;
use App\Http\Controllers\Loans;
use App\Http\Controllers\ManageUserLevel;
use App\Http\Controllers\Menus;
use App\Http\Controllers\Permissions;
use App\Http\Controllers\Processors;
use App\Http\Controllers\Providers;
use App\Http\Controllers\Roles;
use App\Http\Controllers\Services;
use App\Http\Controllers\Routing;
use App\Http\Controllers\Statistics;
use App\Http\Controllers\TerminalGroupTerminals;
use App\Http\Controllers\TerminalMenus;
use App\Http\Controllers\TerminalProcessors;
use App\Http\Controllers\Terminals;
use App\Http\Controllers\Transactions;
use App\Http\Controllers\UserKycDocs;
use App\Http\Controllers\Users;
use App\Http\Controllers\Wallets;
use App\Http\Controllers\TerminalGroups;
use App\Http\Controllers\WalletTransactions;
use App\Models\Role;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\DisputeController;

/*Route::get('dark-mode-switcher', [DarkModeController::class, 'switch'])->name('dark-mode-switcher');
Route::get('color-scheme-switcher/{color_scheme}', [ColorSchemeController::class, 'switch'])->name('color-scheme-switcher');*/


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/',                 Dashboard::class)->name('dashboard');
    Route::get('statistics/{user?}',       Statistics::class)->name('statistics');

    Route::prefix('manage-users')->group(function () {
        Route::controller(Admin::class)->prefix('admins')->name('admins.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/register', 'create')->name('register');
        });

        Route::controller(Agent::class)->name('agents.')->group(function () {
            Route::get(str(Role::AGENT)->lower(), 'index')->name('index');
            Route::get('onboard', 'create')->name('onboard');
        });

        Route::controller(Agent::class)->name('super-agents.')->group(function () {
            Route::get(str(Role::SUPERAGENT)->lower(), 'index')->name('index');
        });
    });

    Route::controller(GeneralLedgers::class)->prefix('general-ledger')->name('general-ledger.')->group(function () {
        Route::get('/', 'show')->name('show');
        Route::get('/others', 'index')->name('others');
        Route::post('/{gl}/update', 'update')->name('update');
    });

    Route::controller(ActivityLogController::class)->prefix('activities')->name('activities.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{activity}', 'show')->name('show');
    });

    Route::resource('users',                        Users::class)->only(['show', 'update', 'store']);
    Route::resource('terminals',                    Terminals::class)->except(['destroy', 'edit', 'create']);
    Route::resource('users.kyc-docs',               UserKycDocs::class)->shallow()->only(['index', 'store']);
    Route::resource('users.manage-level',           ManageUserLevel::class)->only(['index', 'store']);
    Route::resource('kyc-docs',                     KycDocs::class)->shallow()->except(['edit', 'show']);
    Route::resource('transactions',                 Transactions::class)->only('index');
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

Route::get('send-test-mail', function () {
    if (! App::hasDebugModeEnabled()) throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();

    $email = request('email', 'lyte.onyema@gmail.com');

    Notification::route('mail', $email)->notify(new \App\Notifications\Sample);

    return to_route('dashboard');
});

require __DIR__.'/auth.php';
