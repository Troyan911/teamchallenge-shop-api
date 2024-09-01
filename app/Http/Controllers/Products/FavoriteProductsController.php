<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\FavoriteProducts;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class FavoriteProductsController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listOfFavoriteProducts = FavoriteProducts::where('user_id', auth()->user()->id)->pluck('product_id');

        if (!$listOfFavoriteProducts->isEmpty()) {
            return response()->json([
                'Product ID\'s of favorite products' => $listOfFavoriteProducts
            ]);
        } else {
            return response()->json([
                'message' => 'The user hasn\'t had favorite products yet'
            ], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $listOfFavoriteProducts = FavoriteProducts::where('user_id', auth()->user()->id)->pluck('product_id');

       $request->validate([
           'favoriteID'=>'required'
       ], [
       'favoriteID.required' => 'The favoriteID field is required and cannot be empty. Add "favoriteID" to body and try again ']
       );


        if (!$listOfFavoriteProducts->contains($request->favoriteID)) {
            $favorite = new FavoriteProducts;
            $favorite->user_id = auth()->user()->id;
            $favorite->product_id = $request->favoriteID;
            $favorite->save();

            return response()->json([
                'message' => 'The product has been successfully added to the favorite list'
            ]);
        }else{
            return response()->json([
                'message' => 'The product has been in favorite list already'
            ]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
        $listOfFavoriteProducts = FavoriteProducts::where('user_id', auth()->user()->id)->pluck('product_id');

        if ($listOfFavoriteProducts->contains($id)){
            FavoriteProducts::where('user_id', auth()->user()->id)
                ->where('product_id',$id)
                ->delete();
            return response()->json([
                'message' => 'The product has been successfully removed from the favorite list'
            ]);
        }else{
            return response()->json([
                'message' => 'Nothing to remove from favorite list. The product has been removed already'
            ]);
        }
    }
}
