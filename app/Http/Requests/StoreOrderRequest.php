<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreOrderRequest extends FormRequest
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
     * @return array<string, string> Validation rules
     */
    public function rules(): array
    {
        return [
            'price' => 'required|numeric',
            'userId' => 'required|uuid',
            'products' => 'required|array',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     * @return array<string, string> Error messages
     */
    public function messages(): array
    {
        return [
            'userId.required' => 'The user ID is required',
            'userId.uuid' => 'The user ID must be a valid UUID',
            'price.required' => 'The price is required',
            'price.numeric' => 'The price must be a number',
            'products.required' => 'The products are required',
        ];
    }

    /**
     * Handle a failed validation attempt.
     * @param Validator $validator The validator that failed
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
