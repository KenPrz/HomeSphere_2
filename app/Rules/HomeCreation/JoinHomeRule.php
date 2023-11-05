<?php

namespace App\Rules\HomeCreation;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;
class JoinHomeRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $home = DB::table('homes')->where('invite_code', $value)->exists();

        if(!$home){
            $fail('Invalid invite code!');
        }
    }
}
