<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user_id === auth()->id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'content' => ['required', 'string', 'max:200'],
            'user_id' => ['required', 'string'],
            'product_id' => ['required', 'string'],
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
            'content.required' => 'The content is required',
            'content.string' => 'The content must be a string',
            'content.max' => 'The content must not be greater than 200 characters',
            'user_id.required' => 'The user_id is required',
            'user_id.string' => 'The user_id must be a string',
            'product_id.required' => 'The product_id is required',
            'product_id.string' => 'The product_id must be a string',
        ];
    }
}
