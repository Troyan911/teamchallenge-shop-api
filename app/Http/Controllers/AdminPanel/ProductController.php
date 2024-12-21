<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use App\Enums\Products\Gender;
use App\Enums\Products\Size as sizeEnum;
use App\Models\Size;
use App\Models\Color;
use App\Models\Image;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('ProductList', [
            'listOfProducts' => Product::with('variants')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('AddProduct', [
            'gender' => Gender::cases(),
            'size' => Size::pluck('name', 'id')->toArray(),
            'color' => Color::pluck('name', 'id')->toArray()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {

        //Save product

        $newProduct = new Product;
        $newProduct->slug = $request->get('slug');
        $newProduct->directory = $request->get('directory');
        $newProduct->title = $request->get('title');
        $newProduct->description = $request->get('description');
        $newProduct->SKU = $request->get('SKU');
        $newProduct->gender = $request->get('gender');
        $newProduct->price = $request->get('price');
        $newProduct->new_price = $request->get('newPrice');
        $newProduct->save();

        foreach ($request->all()['photo'] as $photo) {

            //Save Photo

            $path = $photo['photo'][0]->store($request->get('directory'), 'public');
            $newPhoto = new Image();
            $newPhoto->path = $path;
            $newPhoto->imageable_id = true;
            $newPhoto->imageable_type = true;
            $newPhoto->save();

            //Save product variants for all possible sizes for this color.

            foreach (sizeEnum::cases() as $item) {

                $productsVariantInDB = new ProductVariant();
                $productsVariantInDB->product_id = $newProduct->id;
                $productsVariantInDB->color_id = $photo['color'];
                $productsVariantInDB->size_id = Size::where('name', $item->value)->get()->pluck('id')[0];
                $productsVariantInDB->photo_id = $newPhoto->id;
                $productsVariantInDB->save();
            }

        }

        return redirect()->back()->with([
            'message' => 'The Product successfully saved',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return Inertia::render('CardOfProduct', [
            'ProductCard' => Product::find($id),
            'ColorsAndImages' => ProductVariant::where('product_id', $id)->get()->pluck('color_id','photo_id')->unique()
               ->map(function ($items,$key) {
                    return [
                        'color' => Color::find($items)->name,
                        'hexOfColor' => Color::find($items)->hex_code,
                        'path' => url('storage/' . Image::find($key)->path)
                    ];
                })
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        Storage::disk('public')->deleteDirectory(Product::find($id)->directory);

        $delete = Product::find($id);
        $delete->delete();


        return redirect()->route('product.index')->with([
            'message' => 'The delete successfully',
        ]);
    }

    public function checkUniquenessOfTitleAndSlug(Request $request)
    {

        $checkTitle = Product::firstWhere('title', $request->get('title'));

        $checkSlug = Product::firstWhere('slug', $request->get('slug'));

        if ($checkTitle == null && $checkSlug == null) {
            return redirect()->back()->with([
                'messageUnique' => 'Both unique',
            ]);
        }

        if ($checkTitle != null && $checkSlug != null) {
            return redirect()->back()->with([
                'messageUnique' => 'Both has been taken.',
            ]);
        }

        if ($checkTitle != null && $checkSlug == null) {
            return redirect()->back()->with([
                'messageUnique' => 'Title has been taken.',
            ]);
        }
        if ($checkTitle == null && $checkSlug != null) {
            return redirect()->back()->with([
                'messageUnique' => 'Slug has been taken.',
            ]);
        }
    }

}
