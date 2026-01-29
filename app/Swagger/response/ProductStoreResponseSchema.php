<?php

namespace App\Swagger\response;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ProductStoreResponse',
   allOf: [
        new OA\Schema(ref: '#/components/schemas/Product'),
        new OA\Schema(
            type: 'object',
            properties: [
                new OA\Property(
                    property: 'unit',
                    ref: '#/components/schemas/Unit'
                )
            ]
        )
   ]
)]
class ProductStoreResponseSchema {}
