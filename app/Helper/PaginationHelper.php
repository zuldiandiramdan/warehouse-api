<?php

namespace App\Helper;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PaginationHelper
{
    public static function paginate(
        Builder $query,
        Request $request,
        int $defaultLimit = 10,
        int $maxLimit = 300,
        string $defaultSortBy = 'id',
        string $defaultSortDir = 'asc',
        array $allowedSortColumns = []
    ) {
        $limit = (int) $request->query('limit', $defaultLimit);

        if ($limit <= 0) {
            $limit = $defaultLimit;
        }

        if ($limit > $maxLimit) {
            $limit = $maxLimit;
        }

        $sortBy  = $request->query('sort_by', $defaultSortBy);
        $sortDir = strtolower($request->query('sort_order', $defaultSortDir)) === 'asc' ? 'asc' : 'desc';

        if (!empty($allowedSortColumns) && !in_array($sortBy, $allowedSortColumns, true)) {
            $sortBy = $defaultSortBy;
        }

        $query->orderBy($sortBy, $sortDir);

        return $query->paginate($limit);
    }
}
