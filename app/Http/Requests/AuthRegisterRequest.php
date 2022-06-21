<?php

namespace App\Http\Requests;

use App\Rules\PhoneUniqueRule;
use Illuminate\Foundation\Http\FormRequest;

class AuthRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|string|min:3',
            'email' => 'required|unique:users,email|email:dns,spoof',
            'password' => 'required|string|min:8',
        ];

        return $rules;
    }
}
