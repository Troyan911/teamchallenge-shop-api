<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can(config('permission.permissions.products.publish'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:2', 'max:255'],
            'description' => ['nullable', 'string'],
            'SKU' => ['required', 'string', 'min:1', 'max:35'],
            'price' => ['required', 'numeric', 'min:0'],
            'new_price' => ['nullable', 'numeric', 'min:0'],
            'thumbnail' => ['nullable', 'image:jpeg,png'],
            'images.*' => ['nullable', 'image:jpeg,png'],
        ];
    }
}
