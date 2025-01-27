<?php

namespace App\Http\Requests;

use App\Models\Shop;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreShopRequest extends FormRequest
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
     * @return array<string, string> The validation rules for the request
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'biography' => ['required', 'string', 'max:200'],
            'theme' => ['string', 'max:20'],
            'logo' => ['required', 'string'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'name.max' => 'Name must not exceed 50 characters',
            'biography.required' => 'Biography is required',
            'biography.string' => 'Biography must be a string',
            'biography.max' => 'Biography must not exceed 200 characters',
            'theme.string' => 'Theme must be a string',
            'theme.max' => 'Theme must not exceed 20 characters',
            'logo.required' => 'Logo is required',
            'logo.string' => 'Logo must be a string',
        ];
    }
}
