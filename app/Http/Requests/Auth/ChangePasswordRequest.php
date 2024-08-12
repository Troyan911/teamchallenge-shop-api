<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ChangePasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required']
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = new JsonResponse(['data' => [],
            'meta' => [
                'message' => 'Request body is invalid',
                'errors' => $validator->errors()
            ]], 422);

        throw new ValidationException($validator, $response);
    }
}
