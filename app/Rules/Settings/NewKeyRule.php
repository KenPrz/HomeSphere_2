<?php

namespace App\Rules\Settings;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Http\Controllers\AppUtilities;
class NewKeyRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $appUtilities = New AppUtilities;
        $user = auth()->user();
        $homeData = $appUtilities->findHomeData($user);
        $apiKey = $appUtilities->getApiKey($homeData);
        if ($value !== $apiKey->api_key) {
            $fail('Api keys do not match.');
        }
    }
}
