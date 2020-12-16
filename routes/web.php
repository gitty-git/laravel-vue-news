<?php

use App\Http\Controllers\ArtsController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\EntertainmentController;
use App\Http\Controllers\GamesController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PoliticsController;
use App\Http\Controllers\WorldController;
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
Route::get('/category/{slug}', [HomeController::class, 'category']);
Route::get('/post/{slug}', [HomeController::class, 'post']);

//Route::get('/categories', CategoriesController::class);

Route::resource('/politics', PoliticsController::class);
Route::resource('/world', WorldController::class);
Route::resource('/health', HealthController::class);
Route::resource('/business', BusinessController::class);
Route::resource('/entertainment', EntertainmentController::class);
Route::resource('/arts', ArtsController::class);
Route::resource('/games', GamesController::class);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');
