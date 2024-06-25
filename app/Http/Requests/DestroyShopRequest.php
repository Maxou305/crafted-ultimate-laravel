<?php

namespace App\Http\Requests;

use App\Models\Shop;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class DestroyShopRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool True if the user is authorized, false otherwise
     */
    public function authorize(): bool
    {
        return Auth::id() === $this->user()->id;
    }

    /**
     * Prepare the data for validation.
     */
    public function prepareForValidation(): void
    {
        $shop = Shop::find($this->id);
        if ($shop === null) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Shop not found',
            ], 404));
        }
    }
}
