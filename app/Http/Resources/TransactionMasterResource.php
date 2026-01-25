<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionMasterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'transaction_date' => $this->transaction_date,

            'transaction_type' => new TransactionTypeResource(
                $this->whenLoaded('transactionType')
            ),

            'items' => TransactionDetailResource::collection(
                $this->whenLoaded('details')
            ),

            'created_at' => $this->created_at,
        ];
    }
}
