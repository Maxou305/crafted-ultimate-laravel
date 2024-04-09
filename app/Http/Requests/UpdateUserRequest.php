<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // TODO add authorization logic
        return true;
    }

    public function prepareForValidation(): void
    {
        $user = User::find($this->id);
        if ($user === null) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404));
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'pseudo' => ['nullable', 'string', 'max:20'],
            'name' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email'],
            'password' => ['nullable', 'string'],
            'payment_address' => ['nullable', 'string', 'max:50'],
            'shipping_address' => ['nullable', 'string', 'max:50'],
            'phone_number' => ['nullable', 'string', 'max:10'],
            'profile_picture' => ['nullable', 'string'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'pseudo.string' => 'The pseudo must be a string',
            'pseudo.max' => 'The pseudo must not be greater than 20 characters',
            'name.string' => 'The name must be a string',
            'name.max' => 'The name must not be greater than 30 characters',
            'email.email' => 'The email must be a valid email',
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

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ]));
    }
}