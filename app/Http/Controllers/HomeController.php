<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\PrimaryCategoryPost;
use App\Models\PrimaryPost;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::query()->get();

        $primaryPosts = PrimaryPost::query()->where('is_published', 1)->latest()->limit(3)->get();

//        $categoryPrimaryPosts = PrimaryCategoryPost::query()->limit(2)->get();

//        $cats = ['politics', 'world', 'business', 'health', 'arts',  'entertainment', 'games'];

//        $posts = Category::query()->with('posts', );

        foreach ($categories as $cat) {
            $primaryCategoriesPosts[$cat->name] = PrimaryCategoryPost::query()->whereHas('category', function ($query) use ($cat) {
                $query->where('name', ucfirst($cat));
            })->where('is_published', 1)->latest()->limit(2)->with('category')->get();

            Post::query()->whereHas('category', function ($query) use ($cat) {
                $query->where('name', ucfirst($cat));
            })->where('is_published', 1)->latest()->limit(2)->get();
        }

        return Inertia::render('Home',
            compact('categories','primaryPosts', 'primaryCategoriesPosts')
        );
    }

    public function category($slug)
    {
        $categories = Category::query()->get();
        $category = Category::query()->where('slug', $slug)->first();

        if ($category) {
            $posts = $category->posts()->latest()->where('is_published', 1)->paginate(20);
            return Inertia::render('Category',
                compact('category', 'posts', 'categories')
            );
        }
        else {
            return Inertia::render('Error.404', 404);
        }
    }
}
