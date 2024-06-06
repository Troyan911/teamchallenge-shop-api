<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'title' => $this->title,
            'SKU' => $this->SKU,
            'quantity' => $this->quantity,
            'description' => $this->description,
            'thumbnail' => url($this->thumbnailUrl),
            'price' => [
                'old' => $this->price,
                'new' => $this->new_price,
                'final' => $this->finalPrice,
                'discount' => $this->discount,
            ],
            'images' => new ImageCollection($this->images),
        ];
    }
}
