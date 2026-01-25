<?php

namespace App\Swagger\request;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'TransactionInsertRequest',
    type: 'object',
    required: ['type', 'items'],
    properties: [
        new OA\Property(
            property: 'type',
            type: 'string',
            example: 'OUT',
            description: 'Must exist in transaction_types.typename'
        ),
        new OA\Property(
            property: 'items',
            type: 'array',
            minItems: 1,
            items: new OA\Items(ref: '#/components/schemas/TransactionItemRequest')
        ),
    ]
)]
class TransactionInsertRequest {}
