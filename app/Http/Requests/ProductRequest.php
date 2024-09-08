<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
//            'photo' => 'mage|mimes:jpeg,png,jpg,gif',
//            'photo.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // If multiple photos
//            'photo' => '', // If a single photo
//            'photo' => 'mimes:jpeg,jpg,png',
//            'photo.*' => 'file|image|max:5048|mimes:jpeg,jpg,png'
        ];
    }

    public function messages():array
    {
        return [

        ];
    }
}
