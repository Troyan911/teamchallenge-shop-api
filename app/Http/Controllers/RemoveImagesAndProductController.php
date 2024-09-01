<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Product;
use App\Policies\Products;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RemoveImagesAndProductController extends Controller
{
    public function __invoke($id)
    {
        try {
            //delete entire folder with photo(s)
            Storage::disk('public')->deleteDirectory(Product::find($id)->directory);

            //delete corresponding product
            Product::find($id)->delete();

            //delete images url from table 'image'
            Image::where('imageable_id', $id)->delete();

            return response()->json(['message' => 'All the photos and product itself were successful deleted.']);

        } catch (\Exception $exception) {
            logs()->error($exception);

            return response(status: 422)->json([
                'message' => $exception->getMessage(),
            ]);
        }
    }
}


