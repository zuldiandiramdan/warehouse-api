<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'PaginatedProductResponse',
    allOf: [
        new OA\Schema(
            properties: [
                new OA\Property(
                    property: 'data',
                    type: 'array',
                    items: new OA\Items(ref: '#/components/schemas/Product')
                )
            ]
        ),
        new OA\Schema(ref: '#/components/schemas/PaginatedResponseBase')
    ]
)]
class PaginatedProductResponse {}
