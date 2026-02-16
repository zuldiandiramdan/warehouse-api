<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUnitRequest extends FormRequest
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
            'unit_name' => ['sometimes','numeric'],
            'is_big_unit' => ['sometimes', 'boolean'],
            'smallest_unit_id' => ['sometimes', 'exists:unit'],
            'smallest_amount' => ['sometimes','numeric']
        ];
    }
}
