<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'product_name' => ['required','max:250'],
            'product_selling_price' => ['required','numeric'],
            'product_buying_price' => ['required','numeric'],
            'unit_id' => ['exists:units,id'],
            'product_stock' => ['nullable','numeric']
        ];
    }
}
