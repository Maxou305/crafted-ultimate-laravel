<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class MeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'authorization' => 'required|string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     * @return array
     */
    public function messages()
    {
        return [];
    }

    /**
     * Handle a failed authorization attempt.
     * @return void
     * @throws AuthorizationException
     */
    public function failedAuthorization(): void
    {
        throw new AuthorizationException('You are not authorized to access this resource', 403);
    }

    /**
     * Handle a failed validation attempt.
     * @param Validator $validator
     * @return void
     * @throws ValidationException
     */
    public function failedValidation(Validator $validator): void
    {
        throw new ValidationException($validator);
    }
}
