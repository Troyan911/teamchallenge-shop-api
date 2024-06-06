<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadImageRequest;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use App\Models\Product;

class ImagesController extends Controller
{
    public function store(UploadImageRequest $request, Product $product)
    {

        try {
            $data = $request->validated();
            $image = $product->images()->create(
                [
                    'path' => [
                        'image' => $data['image'],
                        'directory' => $product->directory,
                    ],
                ]
            );

            return new ImageResource($image);
        } catch (\Exception $exception) {
            logs()->error($exception);

            return response(status: 422)->json([
                'message' => $exception,
            ]);
        }
    }

    public function show(Image $image)
    {
        return new ImageResource($image);
    }
}
