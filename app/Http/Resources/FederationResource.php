<?php

namespace App\Http\Resources;

use App\Models\Federation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Federation
 */
class FederationResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'foundation_date' => $this->foundation_date?->toDateString(),
            'subdivision_id' => $this->subdivision_id,
            'municipality' => $this->municipality,
            'address_line' => $this->address_line,
            'subdivision' => new SubdivisionResource($this->whenLoaded('subdivision')),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
