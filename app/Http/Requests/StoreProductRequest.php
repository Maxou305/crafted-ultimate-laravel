<?php

namespace App\Http\Requests;

use App\Models\Shop;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Auth;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool Whether the user is authorized to make this request
     */
    public function authorize(): bool
    {
        return true;
    }


    /**
     * Get the validation rules that apply to the request.
     * @return array<string, string> The validation rules
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string', 'max:200'],
            'story' => ['required', 'string', 'max:200'],
            'price' => ['required', 'float', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['required', 'string'],
            'category' => ['required', 'string', 'max:20'],
            'color' => ['nullable', 'string', 'max:20'],
            'material' => ['nullable', 'string', 'max:20'],
            'size' => ['nullable', 'string', 'max:10'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     * @return array<string, string> The error messages
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The name is required',
            'name.string' => 'The name must be a string',
            'name.max' => 'The name must not exceed 50 characters',
            'description.required' => 'The description is required',
            'description.string' => 'The description must be a string',
            'description.max' => 'The description must not exceed 200 characters',
            'story.required' => 'The story is required',
            'story.string' => 'The story must be a string',
            'story.max' => 'The story must not exceed 200 characters',
            'price.required' => 'The price is required',
            'price.float' => 'The price must be a float',
            'price.min' => 'The price must be at least 0',
            'stock.required' => 'The stock is required',
            'stock.integer' => 'The stock must be an integer',
            'stock.min' => 'The stock must be at least 0',
            'image.required' => 'The image is required',
            'image.string' => 'The image must be a string',
            'category.required' => 'The category is required',
            'category.string' => 'The category must be a string',
            'category.max' => 'The category must not exceed 20 characters',
            'color.string' => 'The color must be a string',
            'color.max' => 'The color must not exceed 20 characters',
            'material.string' => 'The material must be a string',
            'material.max' => 'The material must not exceed 20 characters',
            'size.string' => 'The size must be a string',
            'size.max' => 'The size must not exceed 10 characters',
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
