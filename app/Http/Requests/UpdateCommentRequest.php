<?php

namespace App\Http\Requests;

use App\Models\Comment;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool True if the user is authorized to make this request, false otherwise
     */
    public function authorize(): bool
    {
        return $this->user_id === auth()->id();
    }

    /**
     * Prepare the data for validation.
     */
    public function prepareForValidation(): void
    {
        $comment = Comment::find($this->id);
        if ($comment === null) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Comment not found',
            ], 404));
        }
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array<string, string> The validation rules for the request data
     */
    public function rules(): array
    {
        return [
            'content' => ['nullable', 'string'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'content.string' => 'The content must be a string',
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
