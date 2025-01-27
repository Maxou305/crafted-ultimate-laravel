<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Auth;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool True if the user is authorized, false otherwise
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array<string, string> The validation rules for the request
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'max:20'],
            'name' => ['nullable','string', 'max:30'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'payment_address' => ['nullable', 'string', 'max:50'],
            'shipping_address' => ['nullable', 'string', 'max:50'],
            'phone_number' => ['nullable', 'string', 'max:10'],
            'profile_picture' => ['nullable', 'string'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     * @return array<string, string> The error messages for the validation rules
     */
    public function messages(): array
    {
        return [
            'username.string' => 'The username must be a string',
            'username.max' => 'The username must not be greater than 20 characters',
            'name.string' => 'The name must be a string',
            'name.max' => 'The name must not be greater than 30 characters',
            'email.required' => 'The email is required',
            'email.email' => 'The email must be a valid email',
            'password.required' => 'The password is required',
            'password.string' => 'The password must be a string',
            'payment_address.string' => 'The payment address must be a string',
            'payment_address.max' => 'The payment address must not be greater than 50 characters',
            'shipping_address.string' => 'The shipping address must be a string',
            'shipping_address.max' => 'The shipping address must not be greater than 50 characters',
            'phone_number.string' => 'The phone number must be a string',
            'phone_number.max' => 'The phone number must not be greater than 10 characters',
            'profile_picture.string' => 'The profile picture must be a string',
        ];
    }

    /**
     * Handle a failed validation attempt.
     * @param Validator $validator The validator instance
     * @return HttpResponseException The HTTP response exception
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ]));
    }
}
