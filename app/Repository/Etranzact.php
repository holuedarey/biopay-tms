<?php

namespace App\Repository;

use App\Contracts\TransferServiceInterface;
use App\Helpers\General;
use App\Helpers\Result;
use App\Models\Bank;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Etranzact implements TransferServiceInterface
{
    public static function name(): string
    {
        return 'ETRANZACT';
    }

    private static function encryptPin(string $pin): string
    {
        $master_key = substr('YO~R><cS,~j~0DkqgQA,M8.eMl45|8=', 0, 16);

        $pad = 16 - (strlen($pin) % 16);

        $pin = $pin . str_repeat(chr($pad), $pad);

        $cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
        mcrypt_generic_init($cipher, $master_key, $master_key);

        return base64_encode(mcrypt_generic($cipher, $pin));
    }

    private static function getPin(): string
    {
        return \App::isProduction() ? config('providers.etranzact.pin_enc.live'): config('providers.etranzact.pin_enc.test');
    }

    private static function createRequest(
        string $action,
        string $reference,
        string $code = null,
        string $account = null,
        string $amount = null,
        string $endpoint = null,
        string $description = null,
    ): array
    {
        $payload = [
            "action"        => $action,
            "terminalId"    => \App::isProduction() ? config('providers.etranzact.tid.live') : config('providers.etranzact.tid.test')
        ];

        $transaction = [
            'pin'           => self::getPin(),
            'reference'     => $reference,
            'bankCode'      => $code,
            'destination'   => $account,
            'amount'        => $amount,
            'endPoint'      => $endpoint,
            'description'   => $description
        ];

        $payload['transaction'] = array_filter($transaction);

        return $payload;
    }

    private static function getHeaders(): array
    {
        return [
            "Accept: application/json",
            "Content-Type: application/json"
        ];
    }

    private static function url(string $endpoint): string
    {
        $url = \App::isProduction() ? config('providers.etranzact.url.live') : config('providers.etranzact.url.test');

        return $url . $endpoint;
    }

    /**
     * @return Result
     */
    public function updateBankList(): Result
    {
        try {
            $method = 'POST';
            $url = self::url('/banks');
            $headers = self::getHeaders();

            $reference = General::generateReference();

            $payload = self::createRequest(action: 'BL', reference: $reference);

            $res = HttpClient::send($headers, $method, $url, json_encode($payload));

            // Decode response body
            $data = json_decode($res['RESPONSE_BODY']);

            if ($res['HTTP_CODE'] == 200 && $data->error == 0) {

                $banks = collect(explode("</bank>", $data->message));

                if ($banks->isNotEmpty()) {
                    Bank::whereProvider(self::name())->delete();

                    $banks->each(function ($index) use ($banks) {
                        if ($index != '</Banks>') {
                            $bank_name = Str::between($index, '<bankName>', '</bankName>');
                            $bank_code = Str::between($index, '<bankCode>', '</bankCode>');

                            Bank::create([
                                'name' => $bank_name,
                                'code' => $bank_code,
                                'provider' => self::name()
                            ]);
                        }
                    });
                }

                // Return response if code is not 200
                return new Result(true, message: 'Bank list updated.');
            }

            Log::error("==========ET BANK LIST ERROR==========\n ", [$payload, $res]);

            // Return response if code is not 200
            return new Result(false, message: $data->message ?? "Error updating bank list.");
        }
        catch (\Exception $exception ) {
            Log::error("==============ET BANK LIST EXCEPTION============\n {$exception->getMessage()}");

            return new Result(false, message: "Exception: {$exception->getMessage()}");
        }
    }

    /**
     * @param string $code
     * @param string $accountNumber
     * @return Result
     */
    public function validateAccount(string $code, string $accountNumber): Result
    {
        $payload = \App::isProduction() ? self::createRequest(action: 'AQ', reference: General::generateReference(), code: $code, account: $accountNumber, amount: '0.0', endpoint: 'A', description: 'Account Query') :
            self::createRequest(action: 'AQ', reference: General::generateReference(), code: '033', account: '2125347370', amount: '0.0', endpoint: 'A', description: 'Account Query');

        $res = HttpClient::send(self::getHeaders(), 'POST', self::url('/account-query'), json_encode($payload));

        // Decode response body
        $data = json_decode($res['RESPONSE_BODY']);

        if ($res['HTTP_CODE'] == 200 && $data->error == 0) {

            $data = ['account_name' => $data->message];

            return new Result(true, $data);
        }

        Log::error("==========ET BANK VALIDATION ERROR==========\n ", [$payload, $res]);

        // Return response if code is not 200
        return new Result(false, message: $data->message ?? "Error with account validation.");
    }

    /**
     * @param string $code
     * @param string $accountNumber
     * @param float $amount
     * @param string $reference
     * @param string $narration
     * @param string|null $bank
     * @param string|null $accountName
     * @return Result
     */
    public function transfer(string $code, string $accountNumber, float $amount, string $narration, string $reference, string $bank = null, string $accountName = null): Result
    {
        $user = auth()->user();

        if (\App::isProduction()) {
            $payload = self::createRequest('FT', $reference, $code, $accountNumber, $amount, 'A', $narration);
            $payload['transaction']['senderName'] = $user->name . ';' . $user->wallet->account_number . ';' . $accountName;
        } else {
            $payload = self::createRequest('FT', $reference, '033', '2125347370', "5", 'A', "Fund Transfer");
            $payload['transaction']['senderName'] = 'Sndr;Acct;Rcvr';
        }

        $res = HttpClient::send(self::getHeaders(), 'POST', self::url('/fund-transfer'), json_encode($payload));

        // Decode response body
        $data = json_decode($res['RESPONSE_BODY']);

        if ($res['HTTP_CODE'] == 200 && $data->error == 0) {
            // Create response for success and pending
            $data = ['message' => $data->message];

            return new Result(true, $data);
        }

        Log::error("==========ET FUND TRANSFER ERROR==========\n ", [$payload, $res]);

        // Return response if code is not 200
        return new Result(false, message: $data->message ?? "Error with fund transfer.");
    }
}
