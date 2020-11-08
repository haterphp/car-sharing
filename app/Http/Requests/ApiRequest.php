<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiRequest extends FormRequest
{
    protected function failedValidation(Validator $validator, $code = 422, $message = 'Validation error')
    {
        throw new HttpResponseException(response()
            ->json([
                'error' => [
                    'code' => $code,
                    'message' => $message,
                    'errors' => $validator->errors()
                ]
            ], $code));
    }
}
