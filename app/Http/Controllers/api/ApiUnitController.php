<?php

namespace App\Http\Controllers\api;

use App\Helper\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
use App\Http\Resources\UnitResource;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class ApiUnitController extends Controller
{
    #[OA\Get(
        path: '/api/units',
        tags: ['Units'],
        summary: 'Get paginated Units',
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
                description: 'Paginated unit list',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/PaginatedUnitResponse'
                )
            )
        ]
    )]
    public function index(Request $request)
    {
        $query = Unit::query();

        if($request->filled('search')) {
            $query->where('unit_name','like','%'.$request->search.'%');
        }

        $units = PaginationHelper::paginate($query, $request);
        return UnitResource::collection($units);
    }

    #[OA\Post(
        path: '/api/units',
        tags: ['Units'],
        summary: 'Store Unit',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: [
                    'unit_name',
                ],
                properties: [
                    new OA\Property(
                        property: 'unit_name',
                        type: 'string'
                    ),
                    new OA\Property(
                        property: 'is_big_unit',
                        type: 'boolean'
                    ),
                    new OA\Property(
                        property: 'smallest_unit_id',
                        type: 'number',
                        format: 'integer'
                    ),
                    new OA\Property(
                        property: 'smallest_amount',
                        type: 'integer'
                    )
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Created Unit',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/Unit'
                )
            )
        ]
    )]
    public function store(StoreUnitRequest $request)
    {
        $unit = Unit::create($request->validated());
        return (new UnitResource($unit)
            ->response()
            ->setStatusCode(201));
    }

    #[OA\Put(
        path: '/api/units/{id}',
        tags: ['Units'],
        summary: 'Update Unit',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(
                    type: 'integer',
                    example: 1
                )
            ),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: 'unit_name',
                        type: 'string'
                    ),
                    new OA\Property(
                        property: 'is_big_unit',
                        type: 'boolean'
                    ),
                    new OA\Property(
                        property: 'smallest_unit_id',
                        type: 'integer'
                    ),
                    new OA\Property(
                        property: 'smallest_amount',
                        type: 'integer'
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Created Unit',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/Unit'
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Product not found'
            )
        ]
    )]
    public function update(UpdateUnitRequest $request, Unit $unit)
    {
        $unit->update($request->validated());
        return (new UnitResource($unit));
    }

    #[OA\Delete(
        path: '/api/units/{id}',
        tags: ['Units'],
        summary: 'Delete Unit',
        description: 'Deletes a unit by ID',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(
                    type: 'integer',
                    example: 1
                )
            ),
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Unit deleted successfully'
            ),
            new OA\Response(
                response: 404,
                description: 'Unit not found'
            )
        ]
    )]
    public function destroy(Unit $unit)
    {
        $unit->delete();
        return response()->noContent();
    }
}
