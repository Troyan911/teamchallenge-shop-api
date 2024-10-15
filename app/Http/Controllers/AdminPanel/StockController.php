<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Stocks', [
            'Stocks' => ProductVariant::all()
                ->map(function ($items) {
                    return [
                        'idOfTypeOfProduct' => $items->id,
                        'nameOfProduct' => Product::find($items->product_id)->title,
                        'color' => Color::find($items->color_id)->name,
                        'hexOfColor' => Color::find($items->color_id)->hex_code,
                        'size' => Size::find($items->size_id)->name,
                        'quantity' => $items->quantity
                    ];
                })
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $productType = ProductVariant::find($id);
        $productType->quantity = $request->get('newQt');
        $productType->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $productTypeDelete=ProductVariant::find($id);
        $productTypeDelete->delete();

        // if we delete all variants for certain photo/color then we delete related photo and directory for storage.

        if(ProductVariant::where('photo_id', $productTypeDelete->photo_id)->get()->count()===0){
            $deletePhoto = Image::find($productTypeDelete->photo_id);
            $deletePhoto->delete();

            Storage::disk('public')->deleteDirectory(Product::find($productTypeDelete->product_id)->directory);
        }

        // If we delete all possible variants then we delete related product.

        if(ProductVariant::where('product_id', $productTypeDelete->product_id)->get()->count()===0){
            $delete = Product::find($productTypeDelete->product_id);
            $delete->delete();
        }


        return redirect()->back();

    }
}
