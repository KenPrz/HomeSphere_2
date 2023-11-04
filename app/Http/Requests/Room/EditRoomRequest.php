<?php

namespace App\Http\Requests\Room;

use App\Rules\Room\RoomUniqueVerify;
use Illuminate\Foundation\Http\FormRequest;

class EditRoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'roomName' => ['string', New RoomUniqueVerify],
            'room_id' => 'required'
        ];
    }
}
