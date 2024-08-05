<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlockResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'blockId' => $this->blockId,
            'sensorLoc' => $this->sensorLoc,
            'sensorId' => $this->sensorId,
            'created_at' => $this->created_at,
        ];
    }
}
