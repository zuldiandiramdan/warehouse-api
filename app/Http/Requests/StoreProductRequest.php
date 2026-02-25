<?php

namespace App\Http\Requests;

use App\Models\Product;

class StoreProductRequest extends MultiTenantRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    protected function getModelClass(): string
    {
        return Product::class;
    }

    public function prepareForValidation()
    {
        $companyId = $this->user()?->currentCompanyId();
        if (!$companyId) {
            abort(403, 'User has no active company');
        }

        $this->merge([
            'company_id' => $companyId,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_name' => ['required', 'max:250'],
            'product_selling_price' => ['required', 'numeric'],
            'product_buying_price' => ['required', 'numeric'],
            // 'unit_id' => ['exists:units,id'],
            'product_stock' => ['nullable', 'numeric'],
            'company_id' => ['required', 'exists:companies,id']
        ];
    }
}
