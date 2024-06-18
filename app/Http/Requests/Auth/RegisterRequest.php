<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'username.required' => 'The username is required',
            'username.string' => 'The username must be a string',
            'username.max' => 'The username must not exceed 20 characters',
            'name.string' => 'The name must be a string',
            'name.max' => 'The name must not exceed 30 characters',
            'email.required' => 'The email is required',
            'email.string' => 'The email must be a string',
            'email.email' => 'The email must be a valid email',
            'email.unique' => 'The email is already taken',
            'password.required' => 'The password is required',
            'password.string' => 'The password must be a string',
            'password.min' => 'The password must be at least 8 characters',
        ];
    }

    /**
     * Handle a failed validation attempt.
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ],
            400));
    }
}
