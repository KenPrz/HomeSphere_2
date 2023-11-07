<?php

namespace App\Rules\Profile;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckChangeDate implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user = auth()->user();
        $nameUpdatedAt = strtotime($user->name_updated_at);
        $currentTimestamp = strtotime(now());
    
        $daysDifference = ($currentTimestamp - $nameUpdatedAt) / (60 * 60 * 24);
        $daysLeft = 60 - $daysDifference;
        if (!($user->name_updated_at === null || $daysDifference >= 60)) {
            $fail('You can\'t change your name for the next ' . number_format($daysLeft, 0) . ' days.');
        }
    }
}