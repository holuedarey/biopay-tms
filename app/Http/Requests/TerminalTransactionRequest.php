<?php

namespace App\Http\Requests;

use App\Exceptions\FailedApiResponse;
use App\Models\Terminal;
use App\Models\Wallet;
use App\Rules\CurrentPin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class TerminalTransactionRequest extends FormRequest
{
    public Terminal $terminal;
    public Wallet $wallet;

    const NAME = '';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Ensure the terminal for this request belongs to the user making the request && the requests wants json.
        return $this->terminal->agent->is($this->user()) && $this->wantsJson();
    }

    protected function prepareForValidation(): void
    {
        $this->terminal = Terminal::forAuthDevice();
        $this->wallet = $this->user()->wallet;
    }

    protected function passesAuthorization()
    {
        $this->terminal->ensureForTransaction();

        // Validate pin for payment
        $this->validate([
            'pin' => ['required', 'not_in:0000', 'bail', new CurrentPin($this->terminal)],
            'CHANNEL' => 'required|in:POS,WEB,MOBILE,OTHERS'
        ]);

        return parent::passesAuthorization();
    }

    protected function passedValidation(): void
    {
        $this->ensureIsNotRateLimited();

        $this->user()->ensureKycChecks($this->float('amount'));
    }

    public function messages(): array
    {
        return [
            'amount.min' => 'Invalid amount entered! Minimum ' . static::NAME . ' amount is NGN:min.'
        ];
    }

    /**
     * Ensure that only one request can be made for the given service per minute.
     *
     * @return void
     * @throws FailedApiResponse
     */
    public function ensureIsNotRateLimited(): void
    {
        $throttle_key = Str::transliterate(Str::lower($this->terminal->serial).'|'.$this->ip() . '|' . static::NAME);

        if (! RateLimiter::attempt($throttle_key, 1, fn() => null)) {
            throw new FailedApiResponse('Too many ' . static::NAME . ' requests. Wait a minute.');
        }
    }
}
