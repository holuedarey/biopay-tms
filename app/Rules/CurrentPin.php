<?php

namespace App\Rules;

use App\Models\Terminal;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Translation\PotentiallyTranslatedString;

class CurrentPin implements ValidationRule
{
    public function __construct(public Terminal $terminal)
    {}

    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param \Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $attribute = str($attribute)->after('current_');

        $msg = 'The :attribute is incorrect.';

        if (! Hash::check($value, $this->terminal->{$attribute})) {
            if ($attribute == 'pin') {
                $this->terminal->wrong_pin_count++;
                $this->terminal->withoutApproval()->save();

                $allowed = 4 - $this->terminal->wrong_pin_count;

                $msg = "$msg You have $allowed more " . str('trial')->when($allowed > 1)->plural()->append('.');

                if ($this->terminal->wrong_pin_count === 4) {
                    $msg = 'You entered the wrong pin 4 times. This terminal has been deactivated.';
                    $this->terminal->status = 'INACTIVE';
                    $this->terminal->withoutApproval()->save();
                }
            }

            $fail($msg);
        }
        else {
            // Reset wrong pin count if pin passes check
            if ($this->terminal->wrong_pin_count > 0) {
                $this->terminal->wrong_pin_count = 0;
                $this->terminal->withoutApproval()->save();
            }
        }
    }
}
