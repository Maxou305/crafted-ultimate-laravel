<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class DestroyProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool True if the user is authorized, false otherwise
     */
    public function authorize(): bool
    {
        return Auth::check() && Product::find($this->id)->user_id === Auth::id();
    }

    /**
     * Prepare the data for validation.
     */
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
}
