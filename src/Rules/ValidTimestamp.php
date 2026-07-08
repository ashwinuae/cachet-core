<?php

namespace Cachet\Rules;

use Closure;
use DateTimeInterface;
use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Support\Carbon;
use Throwable;

class ValidTimestamp implements InvokableRule
{
    /**
     * Run the validation rule.
     */
    public function __invoke($attribute, mixed $value, Closure $fail): void
    {
        if ($value instanceof DateTimeInterface) {
            return;
        }

        if (! is_string($value) && ! is_int($value) && ! is_float($value)) {
            $fail('The :attribute must be a date or Unix timestamp.');

            return;
        }

        try {
            Carbon::parse($value);
        } catch (Throwable) {
            $fail('The :attribute must be a date or Unix timestamp.');
        }
    }
}
