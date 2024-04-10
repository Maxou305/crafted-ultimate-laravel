<?php

namespace App\Http\Requests;

use App\Models\Comment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class DestroyCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool True if the user is authorized, false otherwise
     */
    public function authorize(): bool
    {
        return Auth::check() && $this->user()->id === Comment::find($this->id)->user_id;
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
}
