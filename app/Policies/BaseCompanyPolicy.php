<?php

namespace App\Policies;

use App\Models\User;

abstract class BaseCompanyPolicy
{
    /**
     * Check if the model belongs to the authenticated user's company
     */
    protected function belongsToUserCompany(User $user, $model): bool
    {
        return isset($model->company_id) &&
            $user->companies()->where('companies.id', $model->company_id)->exists();
    }

    public function view(User $user, $model): bool
    {
        return $this->belongsToUserCompany($user, $model);
    }

    public function update(User $user, $model): bool
    {
        return $this->belongsToUserCompany($user, $model);
    }

    public function delete(User $user, $model): bool
    {
        return $this->belongsToUserCompany($user, $model);
    }
}
