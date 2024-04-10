<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:30'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name is required',
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

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ]));
    }
}
