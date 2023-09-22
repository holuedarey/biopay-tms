<x-mail::message>
## Hello {{ $notifiable->first_name}}!

We wish to inform that a <strong>{{ $transaction->action }}</strong> transaction has occurred on your account.

The details of your transaction are below:

{{--    LEAVE THE SPACES THE WAY THEY ARE --}}
<pre style="font-size: 13px;">
    Account number               : {{$transaction->wallet->account_number}}
    Amount                              : {{moneyFormat($transaction->amount)}}
    Service                               : {{$transaction->service->name}}
    Description                        : {{$transaction->info}}
    Date & Time                       : {{$transaction->created_at->toDateTimeString()}}
    Reference                          : {{$transaction->reference}}
</pre>

Your current balance as at {{$transaction->created_at->toDayDateTimeString()}} is <br/>
<strong>{{ moneyFormat($transaction->new_balance) }}</strong>

Thank you for choosing us!

Your financial partner,<br>
{{ config('app.name') }}
</x-mail::message>
