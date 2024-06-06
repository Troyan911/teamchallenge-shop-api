<?php

namespace App\Http\Controllers;

use App\Models\Image;

class RemoveImagesController extends Controller
{
    public function __invoke(Image $image)
    {
        try {
            $image->delete();

            return response()->json(['message' => 'Image was removed']);
        } catch (\Exception $exception) {
            logs()->error($exception);

            return response(status: 422)->json([
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
