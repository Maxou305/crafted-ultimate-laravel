<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool True if the user is authorized, false otherwise
     */
    public function authorize(): bool
    {
//        return Auth::id() === $this->user_id;
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array<string, string> Validation rules
     */
    public function rules(): array
    {
        return [
//            'user_id' => ['required', 'string'],
            'color' => 'nullable|string',
            'material' => 'nullable|string',
            'size' => 'nullable|string',
//            'price' => 'required|numeric',
//            'quantity' => 'required|integer',
//            'product_id' => 'required|string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     * @return array<string, string> Error messages
     */
    public function messages(): array
    {
        return [
//            'user_id.required' => 'The user_id is required',
//            'user_id.string' => 'The user_id must be a string',
            'color.string' => 'The color must be a string',
            'material.string' => 'The material must be a string',
            'size.string' => 'The size must be a string',
            'price.required' => 'The price is required',
            'price.numeric' => 'The price must be a number',
            'quantity.required' => 'The quantity is required',
            'quantity.integer' => 'The quantity must be an integer',
            'product_id.required' => 'The product_id is required',
            'product_id.string' => 'The product_id must be a string',
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
