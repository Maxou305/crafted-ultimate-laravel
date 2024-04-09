<?php

namespace App\Http\Requests;

use App\Models\Shop;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateShopRequest extends FormRequest
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
        $shop = Shop::find($this->id);
        if ($shop === null) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Shop not found',
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
            'name' => ['string', 'max:50'],
            'biography' => ['string', 'max:200'],
            'theme' => ['string', 'max:20'],
            'logo' => ['string'],
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
            'name.string' => 'Name must be a string',
            'name.max' => 'Name must not exceed 50 characters',
            'biography.string' => 'Biography must be a string',
            'biography.max' => 'Biography must not exceed 200 characters',
            'theme.string' => 'Theme must be a string',
            'theme.max' => 'Theme must not exceed 20 characters',
            'logo.string' => 'Logo must be a string',
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