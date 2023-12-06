<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\Profile\CheckChangeDate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUserNameRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'firstName' => ['string', 'max:255',New CheckChangeDate],
            'lastName' => ['string', 'max:255'],
        ];
    }
}
// 