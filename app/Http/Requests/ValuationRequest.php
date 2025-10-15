<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValuationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'mileage' => 'required|integer|min:0',
            'vin' => 'nullable|string|size:17|regex:/^[A-HJ-NPR-Z0-9]+$/',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'vin.size' => 'A VIN must be exactly 17 characters long.',
            'vin.regex' => 'VIN can only contain letters (except I, O, Q) and numbers.',
        ];
    }
}
