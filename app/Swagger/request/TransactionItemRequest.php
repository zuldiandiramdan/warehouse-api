<?php

namespace App\Swagger\request;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'TransactionItemRequest',
    type: 'object',
    required: ['productId', 'productPrice', 'qty'],
    properties: [
        new OA\Property(property: 'productId', type: 'integer', example: 1),
        new OA\Property(property: 'productPrice', type: 'integer', example: 1000),
        new OA\Property(property: 'qty', type: 'integer', example: 5, minimum: 1),
    ]
)]
class TransactionItemRequest {}
