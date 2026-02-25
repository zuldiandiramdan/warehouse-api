<?php

namespace App\Http\Requests;

use App\Models\Unit;
use Illuminate\Foundation\Http\FormRequest;

class StoreUnitRequest extends MultiTenantRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    protected function getModelClass(): string
    {
        return Unit::class;
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
            'unit_name' => ['required'],
            'is_big_unit' => ['sometimes', 'boolean'],
            'smallest_unit_id' => ['sometimes', 'exists:unit'],
            'smallest_amount' => ['sometimes', 'numeric'],
            'company_id' => ['required', 'exists:companies,id']
        ];
    }
}
