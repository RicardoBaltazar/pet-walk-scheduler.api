<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class ProfileRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'address' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^[0-9]{11}$/',
            'owner' => 'required|boolean',
            'walker' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'address.required' => 'The address field is required.',
            'phone.regex' => 'The phone field must contain exactly 11 numeric digits.',
            'owner.boolean' => 'The owner field must be true or false.',
            'walker.boolean' => 'The walker field must be true or false.',
        ];
    }

    protected function withValidator(Validator $validator)
    {
        throw_if($validator->fails(), new HttpResponseException(response()->json([
            'message' => 'Validation error',
            'errors' => $validator->errors(),
        ], Response::HTTP_UNPROCESSABLE_ENTITY)));
    }
}
