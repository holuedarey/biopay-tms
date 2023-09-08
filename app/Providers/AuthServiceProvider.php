<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Helpers\UserHelper;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\HtmlString;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->verifyEmail();
    }

    private function verifyEmail()
    {
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage())
                ->subject('Verify Email Address')
                ->greeting("Hello $notifiable->name!")
                ->line('Welcome to '. config('app.name') .' platform. A new '. $notifiable->roleName . ' account has been created for you with the details below:')
                ->line(new HtmlString('<span><strong>Email: </strong> <i> '. $notifiable->email . '</i></span>'))
                ->line(new HtmlString('<span><strong>Password: </strong> <i> '. UserHelper::generatePassword($notifiable) . '</i></span>'))
                ->line(new HtmlString('<p>Proceed to <a href="'. route('login') .'">Login</a> if you haven\'t before you click the button below to verify your email address.</p>'))
                ->action('Verify Email Address', $url)
                ->line('If you did not create an account, no further action is required.');
        });
    }
}
