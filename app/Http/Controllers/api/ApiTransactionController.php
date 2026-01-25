<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransactionMasterRequest;
use App\Http\Resources\TransactionMasterResource;
use App\Models\TransactionType;
use App\Services\TransactionService;
use OpenApi\Attributes as OA;

class ApiTransactionController extends Controller
{
    #[OA\Post(
        path: '/api/transaction/insert',
        tags: ['TransactionsMaster'],
        summary: 'Create transaction and update product stock',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/TransactionInsertRequest')
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Transaction created',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/TransactionInsertResponse'
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/ValidationErrorResponse'
                )
            )
        ]
    )]
    public function store(
        StoreTransactionMasterRequest $request,
        TransactionService $service
    ) {
        $transactionType = TransactionType::where(
            'type_name',
            $request->input('type')
        )->firstOrFail();

        $transaction = $service->create(
            $transactionType,
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Transaction created successfully',
            'data' => new TransactionMasterResource(
                $transaction->load([
                    'transactionType',
                    'details.product'
                ])
            )
        ], 201);
    }
}
