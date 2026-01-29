<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Helper\PaginationHelper;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class ApiProductController extends Controller
{
    #[OA\Get(
        path: '/api/products',
        tags: ['Products'],
        summary: 'Get paginated products',
        parameters: [
            new OA\Parameter(
                name: 'page',
                in: 'query',
                schema: new OA\Schema(type: 'integer', example: 1)
            ),
            new OA\Parameter(
                name: 'limit',
                in: 'query',
                schema: new OA\Schema(type: 'integer', example: 10)
            ),
            new OA\Parameter(
                name: 'search',
                in: 'query',
                schema: new OA\Schema(type: 'string')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Paginated product list',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/PaginatedProductResponse'
                )
            )
        ]
    )]
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $query->where('product_name', 'like', '%' . $request->search . '%');
        }

        $products = PaginationHelper::paginate($query, $request);

        return ProductResource::collection($products);
    }

    #[OA\Post(
        path: '/api/products',
        tags: ['Products'],
        summary: 'Store Product',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: [
                    'product_name',
                    'product_selling_price',
                    'product_buying_price',
                    'unit_id',
                    'product_stock'
                ],
                properties: [
                    new OA\Property(
                        property: 'product_name',
                        type: 'string'
                    ),
                    new OA\Property(
                        property: 'product_selling_price',
                        type: 'number',
                        format: 'float'
                    ),
                    new OA\Property(
                        property: 'product_buying_price',
                        type: 'number',
                        format: 'float'
                    ),
                    new OA\Property(
                        property: 'unit_id',
                        type: 'integer'
                    ),
                    new OA\Property(
                        property: 'product_stock',
                        type: 'integer'
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Created Product',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/ProductStoreResponse'
                )
            )
        ]
    )]
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());
        $product->load('unit');
        return (new ProductResource($product))
            ->response()
            ->setStatusCode(201);
    }
}
