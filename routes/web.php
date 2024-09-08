<?php

use App\Enums\Products\Gender;
use App\Http\Controllers\ProfileController;
use App\Http\Requests\ProductRequest;
use App\Models\Color;
use App\Models\Image;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Greeting');
})->name('welcome');;

Route::get('/apiDocs', function () {
    return view('/scribe/index');
})->name('apiDocs');

Route::get('/login', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('login');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/addProduct', function () {
    return Inertia::render('AddProduct', [
        'gender' => Gender::cases(),
        'size' => Size::pluck('name')->toArray(),
        'color' => Color::pluck('name')->toArray()
    ]);
})->middleware(['auth', 'verified'])->name('addProduct');


Route::get('/AddColor', function () {
    return Inertia::render('AddColor');
})->middleware(['auth', 'verified'])->name('addColor');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::post('/save', function (ProductRequest $request) {

//    dd($request->all());

    $newProduct = new Product;
    $newProduct->slug = $request->get('slug');
    $newProduct->directory = $request->get('directory');
    $newProduct->title = $request->get('title');
    $newProduct->description = $request->get('description');
    $newProduct->SKU = $request->get('SKU');
    $newProduct->gender = $request->get('gender');
    $newProduct->price = $request->get('price');
    $newProduct->new_price = $request->get('newPrice');
    $newProduct->size = $request->get('size');
    $newProduct->color = $request->get('color');

    $newProduct->save();

    if (!empty($request->all()['photo'])) {
        foreach ($request->all()['photo'] as $photo) {


            $path = $photo->store($request->get('directory'), 'public');
            $originalName = $photo->getClientOriginalName();

            $newPhoto = new Image();
            $newPhoto->product_id = $newProduct->id;
            $newPhoto->path = $path;
            $newPhoto->imageable_id = true;
            $newPhoto->imageable_type = true;
            $newPhoto->save();

        }

    }
    return redirect()->back()->with([
        'message' => 'The save successfully',
    ]);
})->name('save');

Route::post('/saveColor', function (Request $request) {

//    dd($request->all());

    $newColor = new Color();
    $newColor->name = $request->get('colorName');
    $newColor->hex_code = $request->get('hexCode');
    $newColor->save();

    return redirect()->back()->with([
        'message' => 'The save successfully',
    ]);
})->name('saveColor');

require __DIR__ . '/auth.php';
