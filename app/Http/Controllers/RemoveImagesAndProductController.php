<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Policies\Products;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RemoveImagesAndProductController extends Controller
{
    public function __invoke($id)
    {

        try {
            //delete entire folder with photo(s)
            $directory = DB::table('products')->where('id', $id)->first()->directory;
            Storage::disk('public')->deleteDirectory($directory);

            //delete corresponding product
            DB::table('products')->where('id', $id)->delete();

            //delete images url from table 'image'
            DB::table('images')->where('imageable_id', $id)->delete();

            return response()->json(['message' => 'All the photos and product itself were successful deleted.']);

        } catch (\Exception $exception) {
            logs()->error($exception);

            return response(status: 422)->json([
                'message' => $exception->getMessage(),
            ]);
        }


    }
}


