<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VariantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'size' => (new SizeResource($this->whenLoaded('size')))->name,
            'color' => (new ColorResource($this->whenLoaded('color')))->name,
            'quantity' => $this->quantity,
        ];
    }
}
