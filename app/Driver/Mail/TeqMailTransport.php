<?php

namespace App\Driver\Mail;


use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\MessageConverter;

class TeqMailTransport extends AbstractTransport
{
    protected function doSend(SentMessage $message): void
    {
        $email = MessageConverter::toEmail($message->getOriginalMessage());

        $payload = [
            'from' => [
                'address' => config('mail.from.address'),
                'name' => env('APP_NAME')
            ],
            'to' => collect($email->getTo())->map(function (Address $email) {
                return ['email_address' => ['address' => $email->getAddress(), 'name' => $email->getName()]];
            })->all(),
            'subject' => $email->getSubject(),
            'htmlbody' => $email->getHtmlBody(),
        ];

        $token = config('mail.mailers.teqmail.token');

        $response = Http::withHeaders(
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => $token
            ]
        )->post(config('mail.mailers.teqmail.host'), $payload);

    }

    public function __toString(): string
    {
        return 'teqmail';
    }
}