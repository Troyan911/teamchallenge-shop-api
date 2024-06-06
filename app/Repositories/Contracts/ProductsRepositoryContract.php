<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\EditProductRequest;
use App\Models\Product;

interface ProductsRepositoryContract
{
    public function create(CreateProductRequest $request): Product|false;

    public function update(Product $product, EditProductRequest $request): bool;

    public function destroy(Product $product): bool;
}
