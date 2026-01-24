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
        int $maxLimit = 300
    ) {
        $limit = (int) $request->query('limit', $defaultLimit);

        if ($limit <= 0) {
            $limit = $defaultLimit;
        }

        if ($limit > $maxLimit) {
            $limit = $maxLimit;
        }

        return $query->paginate($limit);
    }
}
