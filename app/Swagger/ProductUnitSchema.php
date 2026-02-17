<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ProductUnit',
    type: 'object',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'product_name', type: 'string', example: 'Laptop'),
        new OA\Property(property: 'product_price', type: 'string', example: '77614.00'),
        new OA\Property(property: 'product_stock', type: 'integer', example: 10),
        new OA\Property(
            property: 'unit',
            ref: '#/components/schemas/Unit'
        )
    ]
)]
class ProductUnitSchema {}
