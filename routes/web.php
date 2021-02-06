<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\LikeCommentController;
use App\Http\Controllers\LikeCommentReplyController;
use App\Http\Controllers\MyActivityController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DashboardSearchController;
use App\Http\Controllers\LikePostController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostsByCategory;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersController;
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

Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');
Route::get('/category/{slug}', [PostsByCategory::class, 'show']);

Route::get('/post/{slug}', [PostController::class, 'show'])->name('post.show');
Route::get('/search', [SearchController::class, 'search']);

//Route::resource('/posts', PostsController::class);


Route::middleware(['auth:sanctum'])->group(function () {
//    Route::get('/user', [UsersController::class, 'index']);
//    Route::get( '/dashboard', [AdminController::class, 'index']);
//    Route::get( '/user/profile', [DashboardController::class, 'user']);
//    Route::get('/admin', [DashboardController::class, 'admin']);
    Route::get('/roles', [RolesController::class, 'index'])->name('roles.index');
    Route::resource('/users', UsersController::class);
    Route::resource('comments', CommentsController::class);


    Route::middleware('redactor')->group(function () {
        Route::resource('/posts', PostsController::class);
    });

    // POSTS LIKES CONTROLLER

    Route::get( '/admin/edit-user/{id}', [MyActivityController::class, 'editUser']);

    Route::get('/admin/set-admin/{id}', [MyActivityController::class, 'setAdmin']);
    Route::get('/admin/unset-admin/{id}', [MyActivityController::class, 'unsetAdmin']);

    Route::get('/admin/set-redactor/{id}', [MyActivityController::class, 'setRedactor']);
    Route::get('/admin/unset-redactor/{id}', [MyActivityController::class, 'unsetRedactor']);

    Route::delete('admin/delete-user/{id}', [MyActivityController::class, 'destroy']);

//    Route::middleware('admin')->group(function () {
//        Route::get( '/dashboard', [DashboardController::class, 'index']);
//    });

    Route::post('/post-like/{id}', [LikePostController::class, 'store']);
    Route::post('/comment-like/{id}', [LikeCommentController::class, 'store']);
    Route::post('/comment-reply-like/{id}', [LikeCommentReplyController::class, 'store']);
});

Route::resource('/user', UserController::class);

//Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//    return Inertia\Inertia::render('Dashboard');
//})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/my-activity', [MyActivityController::class, 'index'])->name('my-activity.index');
    Route::get('/user/profile/search', [DashboardSearchController::class, 'search']);
//    Route::resource('/user/profile/post', PostsController::class);

//    Route::middleware('admin')->group(function () {
//        Route::get( '/admin', [AdminController::class, 'index']);
//    });
});
