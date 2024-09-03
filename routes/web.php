<?php

use App\Enums\Products\Gender;
use App\Http\Controllers\ProfileController;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('AddProduct',[
        'gender' => Gender::cases(),
        'size'=> Size::pluck('name')->toArray(),
        'color'=> Color::pluck('name')->toArray()
        ]);
})->middleware(['auth', 'verified'])->name('addProduct');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
