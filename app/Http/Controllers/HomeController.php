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

        $frontPagePosts = Post::query()->where('is_published', 1)->where('type', 'front_page_post')->latest()->limit(3)->get();

//        foreach ($categories as $cat) {
//            $primaryCategoriesPosts[$cat->name] = PrimaryCategoryPost::query()->whereHas('category', function ($query) use ($cat) {
//                $query->where('name', ucfirst($cat));
//            })->where('is_published', 1)->latest()->limit(2)->with('category')->get();
//
//            Post::query()->whereHas('category', function ($query) use ($cat) {
//                $query->where('name', ucfirst($cat));
//            })->where('is_published', 1)->latest()->limit(2)->get();
//        }

//        $types = ['post', 'primary_post', 'first_page_post'];
//        $rand_keys = array_rand($types);
//        echo $types[$rand_keys[0]];
//        dd($types[$rand_keys[1]]);

//        foreach ($categories as $cat) {
//            $categoryPosts[$cat->name] = $cat->primaryCategoryPosts()->latest()->where('is_published', 1)->limit(2)->get();
//
//            $categoryPosts[$cat->name] = $cat->posts()->latest()->where('is_published', 1)->limit(2)->get();
//        }

        return Inertia::render('Home',
            compact('categories', 'frontPagePosts')
        );
    }

//    public function category($slug)
//    {
//        $categories = Category::query()->get();
//        $category = Category::query()->where('slug', $slug)->first();
//
//        if ($category) {
//            $primaryPosts = $category->posts()->latest()->where('is_published', 1)->limit(2)->get();
//            $posts = $category->posts()->latest()->where('is_published', 1)->paginate(20);
//            return Inertia::render('Category',
//                compact('category', 'posts', 'primaryPosts', 'categories')
//            );
//        }
//        else {
//            return Inertia::render('Error.404', 404);
//        }
//    }
}
