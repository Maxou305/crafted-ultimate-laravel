<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class FilterProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // TODO add authorization logic
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array<string, string> The validation rules
     */
    public function rules(): array
    {
        return [
            'name' => ['string'],
            'price' => ['numeric'],
            'category' => ['string'],
            'color' => ['string'],
            'material' => ['string'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     * @return array<string, string> The error messages
     */
    public function messages(): array
    {
        return [
            'name.string' => 'The name must be a string',
            'price.numeric' => 'The price must be a number',
            'category.string' => 'The category must be a string',
            'color.string' => 'The color must be a string',
            'material.string' => 'The material must be a string',
        ];
    }

    /**
     * Handle a failed validation attempt.
     * @param Validator $validator The validator instance
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
