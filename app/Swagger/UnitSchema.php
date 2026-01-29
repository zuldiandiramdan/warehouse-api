<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Unit',
    type: 'object',
    properties: [
        new OA\Property(property: 'id', type: 'integer'),
        new OA\Property(property: 'unit_name', type: 'string'),
        new OA\Property(property: 'is_big_unit', type: 'boolean'),
        new OA\Property(property: 'smallest_unit_id', type: 'integer'),
        new OA\Property(property: 'smallest_amount', type: 'integer'),
    ]
)]
class UnitSchema {}
