<?php

namespace App\Providers;

use App\Driver\Mail\TeqMailTransport;
use App\Models\KycLevel;
use App\Models\Loan;
use App\Models\Service;
use App\Models\Terminal;
use App\Models\TerminalGroup;
use App\Models\User;
use App\Observers\ApprovalObserver;
use App\Observers\KycLevelObserver;
use App\Observers\LoanObserver;
use App\Observers\TerminalGroupObserver;
use App\Observers\TerminalObserver;
use App\Observers\UserObserver;
use Cjmellor\Approval\Models\Approval;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootObservers();
        $this->bootBladeDirectives();

        $this->bootCacheableModels();

        Mail::extend('teqmail', function (array $config = []) {
            return new TeqMailTransport();
        });
    }


    private function bootBladeDirectives(): void
    {
        Blade::directive('money', fn($value) => "<?php echo moneyFormat($value) ?>" );
        Blade::directive('appName', fn($value) => "<?php echo config('app.name') ?>" );
        Blade::directive('nbsp', fn($value) => "<?php echo str_replace(' ', '&nbsp;', $value) ?>" );
    }

    private function bootObservers(): void
    {
        User::observe(UserObserver::class);
        Approval::observe(ApprovalObserver::class);
        KycLevel::observe(KycLevelObserver::class);
        TerminalGroup::observe(TerminalGroupObserver::class);
        Terminal::observe(TerminalObserver::class);
        Loan::observe(LoanObserver::class);
    }

    private function bootCacheableModels(): void
    {
        $this->app->bind('services',
            fn() => Cache::rememberForever('services', fn() => Service::all())
        );

        $this->app->bind('levels',
            fn() => Cache::rememberForever('kyc-levels', fn() => KycLevel::orderBy('max_balance')->get())
        );

        $this->app->bind('menus',
            fn() => Cache::rememberForever('menus', fn() => Service::whereMenu(true)->get())
        );

        $this->app->bind('terminal_groups',
            fn() => Cache::rememberForever('terminal_groups', fn() => TerminalGroup::all())
        );
    }
}
