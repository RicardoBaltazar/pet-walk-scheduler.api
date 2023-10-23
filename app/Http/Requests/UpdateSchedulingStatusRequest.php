<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class UpdateSchedulingStatusRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => 'required|integer',
            'status' => 'required|string|in:agendados,em andamento,concluídos',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'The id field is required.',
            'id.integer' => 'The id field must be an integer.',
            'status.required' => 'The status field is required.',
            'status.string' => 'The status field must be a string.',
            'status.in' => 'The status field must be one of: agendados, em andamento, concluídos.',
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
