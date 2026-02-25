<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class MultiTenantRequest extends FormRequest
{
    public function authorize(): bool
    {
        $model = $this->getModelInstance();

        // Store route → no model yet
        if (!$model) {
            return $this->user()->can('create', $this->getModelClass());
        }

        // Update / delete route → model exists
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
        $paramName = $this->getRouteParameterName();
        if (!$this->route()->hasParameter($paramName)) {
            return null;
        }

        $param = $this->route($paramName);

        if (!$param) return null;

        $modelClass = $this->getModelClass();

        if ($param instanceof $modelClass) {
            return $param;
        }

        return $modelClass::find($param);
    }

    abstract protected function getModelClass(): string;

    protected function getRouteParameterName(): string
    {
        return strtolower(class_basename($this->getModelClass()));
    }
}
