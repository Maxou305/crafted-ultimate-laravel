<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProductRequest extends FormRequest
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
        $product = Product::find($this->id);
        if ($product === null) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Product not found',
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
            'name' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:200'],
            'story' => ['nullable', 'string', 'max:200'],
            'price' => ['nullable', 'float', 'min:0'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'image' => ['nullable', 'string'],
            'category' => ['nullable', 'string', 'max:20'],
            'color' => ['nullable', 'string', 'max:20'],
            'material' => ['nullable', 'string', 'max:20'],
            'size' => ['nullable', 'string', 'max:10'],
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
            'name.string' => 'The name must be a string',
            'name.max' => 'The name must not exceed 50 characters',
            'description.string' => 'The description must be a string',
            'description.max' => 'The description must not exceed 200 characters',
            'story.string' => 'The story must be a string',
            'story.max' => 'The story must not exceed 200 characters',
            'price.float' => 'The price must be a float',
            'price.min' => 'The price must be at least 0',
            'stock.integer' => 'The stock must be an integer',
            'stock.min' => 'The stock must be at least 0',
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
