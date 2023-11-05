<?php

namespace App\Rules\Settings;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class VerifyOwnerRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user = auth()->user();
        
        $data = DB::table('homes')
                ->where('id',$value)
                ->where('owner_id',$user->id)
                ->exists();
        if(!$data){
            $fail('You are not the owner');
        }
    }
}
