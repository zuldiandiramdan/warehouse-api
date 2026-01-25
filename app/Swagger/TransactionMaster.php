<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'TransactionMaster',
    type: 'object',
    properties: [
        new OA\Property(
            property: 'id',
            type: 'integer',
            example: 13
        ),
        new OA\Property(
            property: 'transaction_date',
            type: 'string',
            format: 'date-time',
            example: '2026-01-25T15:19:57.982423Z'
        ),
        new OA\Property(
            property: 'transaction_type',
            ref: '#/components/schemas/TransactionType'
        ),
        new OA\Property(
            property: 'items',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/TransactionItem')
        ),
        new OA\Property(
            property: 'created_at',
            type: 'string',
            format: 'date-time',
            example: '2026-01-25T15:19:57.000000Z'
        ),
    ]
)]
class TransactionMaster {}
