<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\OpenApi(
    info: new OA\Info(
        title: 'My API',
        version: '1.0.0'
    ),
    components: new OA\Components(
        securitySchemes: [
            new OA\SecurityScheme(
                securityScheme: 'sanctum',
                type: 'http',
                scheme: 'bearer',
                bearerFormat: 'JWT'
            )
        ]
    )
)]
class SwaggerController {}
