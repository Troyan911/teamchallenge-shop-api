<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //        dd($this->variants);

        return [
            'id' => $this->id,
            'title' => $this->title,
            'gender' => $this->gender,
            'variants' => VariantResource::collection($this->whenLoaded('variants')),
            'SKU' => $this->SKU,
            'quantity' => $this->quantity,
            'description' => $this->description,
            'thumbnail' => env('APP_URL').Storage::url($this->thumbnail),
            //            'thumbnail' => asset($this->thumbnail),
            //            'thumbnail' => url($this->thumbnailUrl),
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
