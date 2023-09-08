<?php

namespace App\Notifications;

use App\Models\Role;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class AccountRegistration extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(User $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting("Hello $notifiable->first_name!")
            ->line('A new **' . $notifiable->role_name . '** Account has been registered for you on **' . config('app.name') . '**.')
            ->line('Your account login details are given below:')
            ->line(new HtmlString('<blockquote>
        <p>
            <strong>Email:</strong> <em>' . $notifiable->email . '</em> <br />
            <strong>Password:</strong> <em>' . $notifiable->getInitialPassword() . '</em>
        </p>
    </blockquote>'))
            ->line("You'll be required to change your password on first login. Kindly ensure you use a secure password.")
            ->line("If you're a **" . Role::AGENT . '**, kindly proceed to login with your terminal device.')
            ->action('Sign In', route('login'))
            ->line('Thank you for choosing us.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
