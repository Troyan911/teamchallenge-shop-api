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
use App\Models\Size;
use App\Repositories\Contracts\ProductsRepositoryContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * DISPLAY A LIST OF PRODUCTS WITH FILTER.
     *
     * Two parameters are required in a query string:
     *
     *A pagination - numbers of products on one-page.
     *
     *A gender - male or female. Products for unisex add by default.
     *
     * Example:
     * <p><b>http://70.34.242.75/api/products/?pagination=5&gender=female</b></p>
     *
     * Rest of parameters in query string are optional.
     *
     * This could be next parameters: <b>size</b>, <b>color</b>, <b>minPrice</b>,
     * <b>maxPrice</b>, <b>sortOrderByPrice</b> (<b>asc </b>or <b>desc</b>), <b>nameOfProduct</b>.
     *
     * The query string is built by next rule:
     * question mark, then key=value pairs divided by ampersand,
     * ?key1=value1&key2=value2&key3=value3
     *
     * EXAMPLE:
     *
     * <p><b>http://70.34.242.75/api/products/?pagination=5&gender=female&</b></p>
     *<p><b>size=M&minPrice=0&maxPrice=40000&ortOrderByPrice=asc&size=m&color=gray&nameOfProduct=Classic T-Shirts</b></p>
     *
     * @unauthenticated
     *
     * @response {
     *         "meta": {
     *             "colors": [ "red", "blue","green", "gray","black"],
     *             "size": ["s","m","l","xl","xxl","xxxl"],
     *             "minPriceOnStock": 1,
     *             "maxPriceOnStock": 1111
     *             },
     *          "data": {
     *                "listOfProduct": [
     *                      {
     *              "slug": "T-Shirts"
     *              "name": "Classic T-Shirts",
     *              "price": 1111,
     *              "new_price": 1111,
     *               "color": {
     *                       "gray": "#E8E8E8"
     *                       },
     *              "Images_to_product": "http://70.34.242.75/storage/T-F/Dqc85iSFeuHtkraOCkO2hzgntIgtYu2Z9zfUBW7K.png"
     *                }
     *              ],
     *           "current_page": 1,
     *           "last_page": 1,
     *           "per_page": 5,
     *           "total": 1,
     *           "linksPrevious": null,
     *           "linksNext": null
     *           }
     *       }
     */


    //pagination=
    //gender=male / female
    //size=M
    //color=red
    //minPrice=
    //maxPrice=
    //sortOrder=asc desc
    //nameOfProduct


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

        //pagination=
        //gender=male / female
        //size=M
        //color=red
        //minPrice=
        //maxPrice=
        //sortOrder=asc desc
        //nameOfProduct

        //?pagination=5&gender=female&size=M&minPrice=0&maxPrice=40000&sortOrder=asc&size=m&color=gray&nameOfProduct=ff

        $products = Product::whereIn('gender', [$request->get('gender'), 'unisex'])
            ->when($request->minPrice, function ($query) use ($request) {
                $query->where('new_price', '>=', $request->minPrice);
            })
            ->when($request->maxPrice, function ($query) use ($request) {
                $query->where('new_price', '<=', $request->maxPrice);
            })
            ->when($request->ortOrderByPrice, function ($query) use ($request) {
                $query->orderBy('new_price', $request->ortOrderByPrice);
            })
            ->when($request->nameOfProduct, function ($query) use ($request) {
                $query->where('title', 'like', "%{$request->nameOfProduct}%");
            })
            ->with('variants') // Load the product variants
            ->when($request->color, function ($query) use ($request) {
                $query->whereHas('variants', function ($query) use ($request) {
                    $query->where('color_id', Color::where('name', $request->color)->first()->id);
                });
            })
            ->when($request->size, function ($query) use ($request) {
                $query->whereHas('variants', function ($query) use ($request) {
                    $query->where('size_id', Size::where('name', $request->size)->first()->id);
                });
            })
            ->with(['variants' => function ($query) use ($request) {
                $query->orderBy('color_id', 'asc'); // Sort by color_id
            }])
            ->paginate($request->get('pagination'));

        $mappedProducts = $products->map(function ($product) {
            return [
                'slug' => $product->slug,
                'name' => $product->title,
                'price' => $product->price,
                'new_price' => $product->new_price,
                'color' => Color::find(ProductVariant::where('product_id', $product->id)->get()->pluck('color_id'))->pluck('hex_code', 'name'),
                'Images_to_product' => url('storage/' . Image::find(ProductVariant::where('product_id', $product->id)->get()->pluck('photo_id')->unique())->pluck('path')[0])
            ];
        });

        //return response()->json($products);

        return response()->json([
            'meta' => [
                'colors' => Color::all()->pluck('name'),
                'size' => Size::all()->pluck('name')->unique(),
                'minPriceOnStock' => Product::all()->min('new_price'),
                'maxPriceOnStock' => Product::all()->max('new_price'),

            ],
            'data' => [
                'listOfProduct' => $mappedProducts,
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
                'linksPrevious' => $products->previousPageUrl(),
                'linksNext' => $products->nextPageUrl()
            ],

        ]);

        //$products = Product::paginate($request->get('pagination'));
//        $mappedProducts->when($request->minPrice, function ($query) use ($request) {
//                $query->where('new_price', '>=', $request->minPrice);
//            })
//            ->when($request->maxPrice, function ($query) use ($request) {
//                $query->where('new_price', '<=', $request->maxPrice);
//            });
//
//        return response()->json([
//            'query' => $request->all(),
//            'data' => $mappedProducts,
//            'current_page' => $products->currentPage(),
//            'last_page' => $products->lastPage(),
//            'per_page' => $products->perPage(),
//            'total' => $products->total(),
//            'linksPrevious' => $products->previousPageUrl(),
//            'linksNext' => $products->nextPageUrl()
//        ]);

//        $users = DB::table('products')
//            ->rightJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
//
//            ->get();
//
//        return response()->json([
//            'list'=>$users,
//        ]);

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
