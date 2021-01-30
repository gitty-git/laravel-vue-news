<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DashboardSearchController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\SearchController;
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
Route::get('search', [SearchController::class, 'search']);

Route::middleware(['auth:sanctum'])->group(function () {
//    Route::get('/user', [UsersController::class, 'index']);
//    Route::get( '/dashboard', [AdminController::class, 'index']);
    Route::get( '/admin', [DashboardController::class, 'admin']);
//    Route::get( '/user/profile', [DashboardController::class, 'user']);

    Route::get( '/admin/edit-user/{id}', [DashboardController::class, 'editUser']);

    Route::get('/admin/set-admin/{id}', [DashboardController::class, 'setAdmin']);
    Route::get('/admin/unset-admin/{id}', [DashboardController::class, 'unsetAdmin']);

    Route::get('/admin/set-redactor/{id}', [DashboardController::class, 'setRedactor']);
    Route::get('/admin/unset-redactor/{id}', [DashboardController::class, 'unsetRedactor']);

    Route::delete('admin/delete-user/{id}', [DashboardController::class, 'destroy']);

//    Route::middleware('admin')->group(function () {
//        Route::get( '/dashboard', [DashboardController::class, 'index']);
//    });

    Route::post('/posts/{id}/post-like', [PostsController::class, 'postLike']);
    Route::post('/posts/{id}/comment-like', [PostsController::class, 'commentLike']);
});

Route::resource('/user', UsersController::class);

//Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//    return Inertia\Inertia::render('Dashboard');
//})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/user/profile/search', [DashboardSearchController::class, 'search']);
    Route::resource('/user/profile/post', PostsController::class);

    Route::middleware('admin')->group(function () {
        Route::get( '/admin', [AdminController::class, 'index']);
    });
});
