<?php

namespace App\Http\Requests\HomeCreation;

use App\Rules\HomeCreation\JoinHomeRule;
use Illuminate\Foundation\Http\FormRequest;

class JoinHomeRequest extends FormRequest
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
            'home_code' => ['required', 'string', 'size:16',New JoinHomeRule],
        ];
    }
}
