<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'TransactionItem',
    type: 'object',
    properties: [
        new OA\Property(
            property: 'product_id',
            type: 'integer',
            example: 1
        ),
        new OA\Property(
            property: 'price',
            type: 'number',
            format: 'decimal',
            example: 1000.00
        ),
        new OA\Property(
            property: 'qty',
            type: 'integer',
            example: 4
        ),
        new OA\Property(
            property: 'product',
            ref: '#/components/schemas/Product'
        ),
    ]
)]
class TransactionItem {}
