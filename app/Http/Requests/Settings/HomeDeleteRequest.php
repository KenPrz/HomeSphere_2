<?php

namespace App\Http\Requests\Settings;

use App\Rules\PasswordMatchRule;
use App\Rules\Settings\VerifyOwnerRule;
use Illuminate\Foundation\Http\FormRequest;

class HomeDeleteRequest extends FormRequest
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
            'homeID' => ['required', new VerifyOwnerRule],
            'password' => ['required', 'confirmed', new PasswordMatchRule],
        ];
    }
    
}
