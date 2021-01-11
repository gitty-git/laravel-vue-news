<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', [HomeController::class, 'index']);

Route::get('/category', [CategoriesController::class, 'index']);
Route::get('/category/{slug}', [CategoriesController::class, 'show']);

Route::get('/post/{slug}', [PostsController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UsersController::class, 'index']);
});

Route::resource('/user', UsersController::class);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');
