<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'patronymic' => 'string',
            'phone' => 'required|string|unique:users,phone|size:11',
            'birth_date' => 'required|date|before:today',
            'passport_series' => 'required|string|size:4',
            'passport_number' => 'required|string|size:6',
            'password' => 'required|string',
        ];
    }
}
