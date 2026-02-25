<?php

namespace App\Http\Requests;

use App\Models\Product;
use App\Models\Unit;
use App\Rules\BelongsToUserCompany;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends MultiTenantRequest
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
            'product_name' => ['sometimes', 'max:250'],
            'product_selling_price' => ['sometimes', 'numeric'],
            'product_buying_price' => ['sometimes', 'numeric'],
            // 'unit_id' => ['sometimes', BelongsToUserCompany::rule(Unit::class)],
            'company_id' => ['required', 'exists:companies,id']
        ];
    }
}
