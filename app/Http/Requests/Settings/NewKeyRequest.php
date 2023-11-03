<?php

namespace App\Http\Requests\Settings;

use App\Rules\PasswordMatchRule;
use App\Rules\Settings\NewKeyRule;
use Illuminate\Foundation\Http\FormRequest;

class NewKeyRequest extends FormRequest
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
            'oldApiKey' => ['required',new NewKeyRule],
            'password' => ['required', new PasswordMatchRule],
        ];
    }
}
