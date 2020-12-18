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

        $frontPagePosts = Post::query()->where('is_published', 1)
            ->where('type', 'front_page_post')
            ->latest()->limit(3)->get();

//        $posts = Post::query()
//            ->where('type', 'post')
//            ->orWhere('type', 'primary_post')
//            ->get();

//        dd($posts);

        foreach ($categories as $cat) {
            $posts[$cat->name] = $cat->posts()->latest()
                ->where('type', 'post')->limit(14)
                ->get();

            $primaryPosts[$cat->name] = $cat->posts()->latest()
                ->where('type', 'post')->limit(100)
                ->orWhere('type', 'post')->limit(100)
                ->get();
        }

        $a = $primaryPosts + $posts;

//        foreach ($posts as $post) {
//            $post->groupBy('type');
//        }
        dd($a);

        return Inertia::render('Home',
            compact('categories', 'frontPagePosts', 'posts')
        );
    }

    public function category($slug)
    {
        $categories = Category::query()->get();
        $category = Category::query()->where('slug', $slug)->first();

        if ($category) {
            $primaryPosts = $category->posts()->latest()->where('is_published', 1)->where('type', 'primary_post')->limit(2)->get();
            $posts = $category->posts()->latest()->where('is_published', 1)->where('type', 'post')->paginate(20);
            return Inertia::render('Category',
                compact('category', 'posts', 'primaryPosts', 'categories')
            );
        }
        else {
            return Inertia::render('Error.404', 404);
        }
    }
}
