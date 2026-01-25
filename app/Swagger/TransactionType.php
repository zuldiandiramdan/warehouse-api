<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'TransactionType',
    type: 'object',
    properties: [
        new OA\Property(
            property: 'id',
            type: 'integer',
            example: 2
        ),
        new OA\Property(
            property: 'type_name',
            type: 'string',
            example: 'Pengeluaran'
        ),
        new OA\Property(
            property: 'is_decreasing',
            type: 'boolean',
            example: true
        ),
    ]
)]
class TransactionType {}
