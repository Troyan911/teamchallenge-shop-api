<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\EditProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Color;
use App\Models\Product;
use App\Repositories\Contracts\ProductsRepositoryContract;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        $products = Product::with('variants.color', 'variants.size')
//            ->orderByDesc('id')
//            ->paginate(12);
//
//        return (new ProductCollection($products))
//            ->additional(
//                [
//                    'meta_data' => [
//                        'total' => $products->total(),
//                        'per_page' => $products->perPage(),
//                        'page' => $products->currentPage(),
//                        'to' => $products->lastPage(),
//                        'path' => $products->path(),
//                        'next' => $products->nextPageUrl(),
//                    ],
//                ]);
//

        $products = Product::with('images')
            ->paginate(5);

        $mappedProducts = $products->map(function ($product) {
            return [
                'Product_id' => $product->id,
                'Product_slug' => $product->slug,
                'Product_name' => $product->title,
                'Product_description' => $product->description,
                'Product_gender' => $product->gender,
                'Product_color' => $product->color,
                'Product_hex_code' => Color::where('name', $product->color)->get()->pluck('hex_code')[0],
                'Product_size' => $product->size,
                'Product_price' => $product->price,
                'Product_new_price' => $product->new_price,
                'Images_to_product' => $product->images->map(function ($image) {
                    // Customize the image output as you need
                    return [
                        'Photo_id' => $image->id,
                        'Url_to_photo' => url('storage/'.$image->path), // assuming 'filename' is the image field
                    ];
                }),
            ];
        });

        return response()->json([
            'data' => $mappedProducts,
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage(),
            'per_page' => $products->perPage(),
            'total' => $products->total(),
            'linksPrevious'=>$products->previousPageUrl(),
            'linksNext'=>$products->nextPageUrl()
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request, ProductsRepositoryContract $repository)
    {
        return new ProductResource($repository->create($request));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('variants.color', 'variants.size');

        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditProductRequest $request, Product $product, ProductsRepositoryContract $repository)
    {
        $repository->update($product, $request);

        return new ProductResource(Product::with('variants.color', 'variants.size')->find($product->id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, ProductsRepositoryContract $repository)
    {
        return $repository->destroy($product);
    }
}
