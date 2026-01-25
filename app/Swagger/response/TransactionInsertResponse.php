<?php

namespace App\Swagger\Response;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'TransactionInsertResponse',
    type: 'object',
    required: ['success', 'message', 'data'],
    properties: [
        new OA\Property(
            property: 'success',
            type: 'boolean',
            example: true
        ),
        new OA\Property(
            property: 'message',
            type: 'string',
            example: 'Transaction created successfully'
        ),
        new OA\Property(
            property: 'data',
            ref: '#/components/schemas/TransactionMaster'
        ),
    ]
)]
class TransactionInsertResponse {}
