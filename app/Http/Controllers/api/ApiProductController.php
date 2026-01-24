<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Helper\PaginationHelper;
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
    public function getListPaginated(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $query->where('product_name', 'like', '%' . $request->search . '%');
        }

        $products = PaginationHelper::paginate($query, $request);

        return ProductResource::collection($products);
    }
}
