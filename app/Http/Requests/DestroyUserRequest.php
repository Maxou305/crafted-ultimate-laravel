<?php

namespace App\Http\Requests;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class DestroyUserRequest extends FormRequest
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
     * Prepare the data for validation.
     */
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
}
