<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class MultiTenantRequest extends FormRequest
{
    public function authorize(): bool
    {
        $model = $this->getModelInstance();
        if (!$model) return false;

        // Auto-use the policy
        return $this->user()->can('update', $model);
    }

    protected function failedAuthorization(): void
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Data Not Found.',
            ], 404)
        );
    }

    protected function getModelInstance()
    {
        $param = $this->route($this->getRouteParameterName());

        if (!$param) return null;

        $modelClass = $this->getModelClass();

        // If already a model, return it
        if ($param instanceof $modelClass) {
            return $param;
        }

        // Otherwise assume it’s an ID
        return $modelClass::find($param);
    }

    abstract protected function getModelClass(): string;

    protected function getRouteParameterName(): string
    {
        return strtolower(class_basename($this->getModelClass()));
    }
}
