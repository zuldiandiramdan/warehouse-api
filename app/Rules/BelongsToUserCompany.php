<?php

namespace App\Rules;

use Illuminate\Support\Facades\Auth;

class BelongsToUserCompany
{
    protected string $modelClass;

    public function __construct(string $modelClass)
    {
        $this->modelClass = $modelClass;
    }

    /**
     * Invokable rule
     */
    public function __invoke($attribute, $value, $fail)
    {
        $user = Auth::user();

        $exists = $this->modelClass::where('id', $value)
            ->whereIn('company_id', $user->companies()->pluck('companies.id'))
            ->exists();

        if (!$exists) {
            $fail("The selected $attribute is not valid.");
        }
    }

    /**
     * Return a closure rule for Laravel 12
     */
    public static function rule(string $modelClass): callable
    {
        return fn($attribute, $value, $fail) => (new self($modelClass))($attribute, $value, $fail);
    }
}