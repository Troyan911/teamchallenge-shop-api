<?php

namespace App\Repositories;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\EditProductRequest;
use App\Models\Product;
use App\Repositories\Contracts\ImageRepositoryContract;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductsRepository implements Contracts\ProductsRepositoryContract
{
    public function __construct(protected ImageRepositoryContract $imageRepository)
    {
    }

    public function create(CreateProductRequest $request): Product|false
    {
        try {
            DB::beginTransaction();

            $data = $this->formRequestData($request);
            $data['attributes'] = $this->addSlugAndDirToAttributes($data['attributes'], true);

            //            dd($data['attributes']);
            $product = Product::create($data['attributes']);
            $this->setProductData($product, $data);

            DB::commit();

            return $product;
        } catch (\Exception $exception) {
            DB::rollBack();
            logs()->error($exception);

            return false;
        }
    }

    public function update(Product $product, EditProductRequest $request): bool
    {
        try {
            DB::beginTransaction();

            $data = $this->formRequestData($request);
            if ($data['attributes']['title'] && $data['attributes']['title'] !== $product->title) {
                $data['attributes'] = $this->addSlugAndDirToAttributes($data['attributes']);
            }

            $product->update($data['attributes']);
            //            $this->setProductData($product, $data);

            DB::commit();

            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            logs()->warning($exception);

            return false;
        }
    }

    public function destroy(Product $product): bool
    {
        try {
            //            $product->categories()->detach();
            //            $product->followers()->detach();

            $product->deleteOrFail();

            return true;
        } catch (\Exception $exception) {
            logs()->warning($exception);

            return false;
        }
    }

    protected function setProductData(Product $product, array $data): void
    {
        //        if ($product->categories()->exists()) {
        //            $product->categories()->detach();
        //        }
        //
        //        if (! empty($data['categories'])) {
        //            $product->categories()->attach($data['categories']);
        //        }

        if (! empty($data['attributes']['images'])) {
            $this->imageRepository->attach(
                $product,
                'images',
                $data['attributes']['images'],
                $product->directory);
        }
    }

    protected function formRequestData(CreateProductRequest|EditProductRequest $request): array
    {
        return [
            //            'attributes' => collect($request->validated())->except(['categories'])->toArray(),
            'attributes' => collect($request->validated())->toArray(),
            //            'categories' => $request->get('categories', []),
        ];
    }

    protected function addSlugAndDirToAttributes(array $attributes, bool $setDirectory = false): array
    {
        $slug = Str::of($attributes['title'])->slug()->value();

        return array_merge(
            ['slug' => $slug],
            $setDirectory ? ['directory' => $slug] : [],
            $attributes
        );
    }

    public function delete(EditProductRequest $request): Product|false
    {
        return false;
    }
}
