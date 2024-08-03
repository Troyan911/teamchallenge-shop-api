<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['cors']], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::apiResource('products', \App\Http\Controllers\Products\ProductsController::class)->only(['index', 'show']);
    Route::post('products/{product}/images', [\App\Http\Controllers\Products\ImagesController::class, 'storeImage'])->name('product.images.store');
    Route::post('products/{product}/thumbnail', [\App\Http\Controllers\Products\ImagesController::class, 'storeThumbnail'])->name('product.images.store');

    Route::middleware('auth:sanctum')->group(function () {

        Route::apiResource('products', \App\Http\Controllers\Products\ProductsController::class)->except(['index', 'show']);
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::group(['role:admin|moderator'], function () {
            //        Route::post('products/{product}/images', [\App\Http\Controllers\Products\ImagesController::class, 'storeImage'])->name('product.images.store');
            //        Route::post('products/{product}/thumbnail', [\App\Http\Controllers\Products\ImagesController::class, 'storeThumbnail'])->name('product.images.store');
            Route::get('images/{image}', [\App\Http\Controllers\Products\ImagesController::class, 'show'])->name('images.show');
            Route::delete('images/{image}', \App\Http\Controllers\RemoveImagesController::class)->name('images.destroy');
        });

    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
