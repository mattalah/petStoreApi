<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;

use Illuminate\Http\Exceptions\HttpResponseException;

class UpdatePetRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id' => 'required|numeric',
            'name' => 'required|string',
            'photoUrls' => 'required|array',
            'tags' => 'sometimes|array',
            'tags.*.id' => 'required|numeric',
            'tags.*.name' => 'required|string',
            'category.id' =>  'sometimes|numeric',
            'category.name' =>  'sometimes|string',
            "photoUrls.*"  => 'sometimes|string|distinct',
            'status' => 'sometimes|in:available, pending,sold'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json('Validation exception', 405));
    }
}
