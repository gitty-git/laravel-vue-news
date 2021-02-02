<?php

use App\Http\Controllers\CommentLikeController;
use App\Http\Controllers\CommentReplyLikeController;
use App\Http\Controllers\MyActivity;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DashboardSearchController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\PostPageController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
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

Route::get('/post/{slug}', [PostPageController::class, 'index'])->name('post.index');
Route::get('/search', [SearchController::class, 'search']);

Route::middleware(['auth:sanctum'])->group(function () {
//    Route::get('/user', [UsersController::class, 'index']);
//    Route::get( '/dashboard', [AdminController::class, 'index']);
//    Route::get( '/user/profile', [DashboardController::class, 'user']);
//    Route::get('/admin', [DashboardController::class, 'admin']);

    Route::middleware('redactor')->group(function () {
        Route::get('/posts', [PostsController::class, 'index'])->name('posts.index');
        Route::get('/posts/create', [PostsController::class, 'create'])->name('posts.create');
        Route::post('/posts/store', [PostsController::class, 'store'])->name('posts.store');
        Route::get('/posts/{post}/edit', [PostsController::class, 'edit'])->name('posts.edit');
        Route::put('/posts/update', [PostsController::class, 'update'])->name('posts.update');
//        Route::resource('posts', PostsController::class)->only('index', 'create', 'store', 'edit', 'update');
    });

    // POSTS LIKES CONTROLLER

    Route::get( '/admin/edit-user/{id}', [MyActivity::class, 'editUser']);

    Route::get('/admin/set-admin/{id}', [MyActivity::class, 'setAdmin']);
    Route::get('/admin/unset-admin/{id}', [MyActivity::class, 'unsetAdmin']);

    Route::get('/admin/set-redactor/{id}', [MyActivity::class, 'setRedactor']);
    Route::get('/admin/unset-redactor/{id}', [MyActivity::class, 'unsetRedactor']);

    Route::delete('admin/delete-user/{id}', [MyActivity::class, 'destroy']);

//    Route::middleware('admin')->group(function () {
//        Route::get( '/dashboard', [DashboardController::class, 'index']);
//    });

    Route::post('/post-like/{id}', [PostLikeController::class, 'store']);
    Route::post('/comment-like/{id}', [CommentLikeController::class, 'store']);
    Route::post('/comment-reply-like/{id}', [CommentReplyLikeController::class, 'store']);
});

Route::resource('/user', UserController::class);
Route::get('/roles', [RoleController::class, 'index']);

//Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//    return Inertia\Inertia::render('Dashboard');
//})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/my-activity', [MyActivity::class, 'index'])->name('my-activity.index');

    Route::get('/user/profile/search', [DashboardSearchController::class, 'search']);
//    Route::resource('/user/profile/post', PostsController::class);

//    Route::middleware('admin')->group(function () {
//        Route::get( '/admin', [AdminController::class, 'index']);
//    });
});
