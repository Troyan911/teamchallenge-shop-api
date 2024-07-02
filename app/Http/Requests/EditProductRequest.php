<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EditProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can(config('permission.permissions.products.edit'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $productId = $this->route('product')->id;

        return [
            'title' => ['required', 'string', 'min:2', 'max:255'],
            'description' => ['nullable', 'string'],
            'SKU' => ['required', 'string', 'min:1', 'max:35'],
            'price' => ['required', 'numeric', 'min:1'],
            'new_price' => ['nullable', 'numeric', 'min:1'],
            'thumbnail' => ['nullable', 'image:jpeg,png'],
        ];
    }
}
