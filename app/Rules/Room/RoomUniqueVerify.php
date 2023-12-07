<?php

namespace App\Rules\Room;

use App\Http\Controllers\AppUtilities;
use App\Models\Room;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class RoomUniqueVerify implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $appUtilities = new AppUtilities;
        $user = auth()->user();
        $homeData = $appUtilities->findHomeData($user);

        $data = room::where('room_name', $value)
                ->where('home_id', $homeData->id)
                ->exists();

            if($data){
                $fail('Room name already exists in this home!');
            }
    }
}
