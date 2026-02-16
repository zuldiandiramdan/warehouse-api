<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'PaginatedUnitResponse',
    allOf: [
        new OA\Schema(
            properties: [
                new OA\Property(
                    property: 'data',
                    type: 'array',
                    items: new OA\Items(ref: '#/components/schemas/Unit')
                )
            ]
        ),
        new OA\Schema(ref: '#/components/schemas/PaginatedResponseBase')
    ]
)]
class PaginatedUnitResponse {}
