<?php

use App\Http\Controllers\AdminPanel\ColorController;
use App\Http\Controllers\AdminPanel\ProductController;
use App\Http\Controllers\AdminPanel\StockController;
use App\Http\Controllers\ProfileController;
use App\Models\Color;
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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/checkUniquenessOfTitleAndSlug', [ProductController::class, 'checkUniquenessOfTitleAndSlug'])->name('checkUniquenessOfTitleAndSlug');

Route::resource('product', ProductController::class);
Route::resource('stocks', StockController::class)->only(['index', 'update', 'destroy']);
Route::resource('color', ColorController::class)->only(['index', 'create', 'destroy']);

require __DIR__ . '/auth.php';
