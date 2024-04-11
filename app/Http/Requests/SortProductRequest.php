<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class SortProductRequest extends FormRequest
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
            'column' => ['required', 'string'],
            'order' => ['required', 'string', 'in:asc,desc'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     * @return array<string, string> Error messages
     */
    public function messages(): array
    {
        return [
            'column.required' => 'The column is required',
            'column.string' => 'The column must be a string',
            'order.required' => 'The order is required',
            'order.string' => 'The order must be a string',
            'order.in' => 'The order must be asc or desc',
        ];
    }

    /**
     * Handle a failed validation attempt.
     * @param Validator $validator The validator that failed
     * @return void
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
