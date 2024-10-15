<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\EditProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Color;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Repositories\Contracts\ProductsRepositoryContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
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

        $products = Product::whereIn('gender', [$request->get('gender'), 'unisex'])->paginate(10);

        $mappedProducts = $products->map(function ($product) {
            return [
                'slug' => $product->slug,
                'name' => $product->title,
                'price' => $product->price,
                'new_price' => $product->new_price,
                'color' => Color::find(ProductVariant::where('product_id',$product->id)->get()->pluck('color_id'))->pluck('hex_code','name'),
                'Images_to_product' =>url('storage/'.Image::find(ProductVariant::where('product_id', $product->id)->get()->pluck('photo_id')->unique())->pluck('path')[0])
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
