<?php

namespace App\Http\Requests;

use App\Rules\TimeFormatRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class AvailabilityRequest extends FormRequest
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
            'date' => 'required|date_format:Y-m-d',
            'start_time' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    $hour = intval(date('H', strtotime($value)));
                    $minute = intval(date('i', strtotime($value)));

                    if (($hour < 6 || $hour >= 24) || ($minute !== 0 && $minute !== 30)) {
                        $fail('The time must be a full hour or half hour between 6am and 11:30pm.');
                    }
                },
            ],
            'end_time' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    $hour = intval(date('H', strtotime($value)));
                    $minute = intval(date('i', strtotime($value)));

                    if (($hour < 6 || $hour >= 24) || ($minute !== 0 && $minute !== 30)) {
                        $fail('The time must be a full hour or half hour between 6am and 11:30pm.');
                    }
                },
            ],
        ];
    }

    public function messages()
    {
        return [
            'date.required' => 'The date field is required.',
            'date.date_format' => 'The date must be in the format YYYY-MM-DD.',
            'start_time.required' => 'The start time field is required.',
            'start_time.date_format' => 'The start time must be in the format HH:MM.',
            'start_time.regex' => 'The start time must be a full hour or half hour between 6am and 11:30pm. Ex: 10:00, 10:30',
            'end_time.required' => 'The end time field is required.',
            'end_time.date_format' => 'The end time must be in the format HH:MM.',
            'end_time.regex' => 'The end time must be a full hour or half hour between 6am and 11:30pm.',
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
