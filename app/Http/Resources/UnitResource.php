<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitResource extends JsonResource
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
            'unit_name' => $this->unit_name,
            'is_big_unit' => $this->is_big_unit,
            'smallest_unit_id' => $this->smallest_unit_id,
            'smallest_amount' => $this->smallest_amount
        ];
    }
}
