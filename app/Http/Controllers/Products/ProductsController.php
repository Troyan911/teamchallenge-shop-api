<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\EditProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\Contracts\ProductsRepositoryContract;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('variants.color', 'variants.size')
            ->orderByDesc('id')
            ->paginate(12);

        return (new ProductCollection($products))
            ->additional(
                [
                    'meta_data' => [
                        'total' => $products->total(),
                        'per_page' => $products->perPage(),
                        'page' => $products->currentPage(),
                        'to' => $products->lastPage(),
                        'path' => $products->path(),
                        'next' => $products->nextPageUrl(),
                    ],
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
