<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
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

        foreach ($categories as $cat) {
            $primaryPosts[$cat->name] = $cat->posts()->latest()
                ->where('type', 'primary_post')->limit(2)
                ->get();

            $posts[$cat->name] = $cat->posts()->latest()
                ->where('type', 'post')->limit(3)
                ->get();
        }

//        dd($posts, $primaryPosts);

        return Inertia::render('Home',
            compact('categories', 'frontPagePosts', 'posts', 'primaryPosts')
        );
    }

    public function category($slug)
    {
        $categories = Category::query()->get();
        $category = Category::query()->where('slug', $slug)->first();

        if ($category) {
            $primaryPosts = $category->posts()->latest()->where('is_published', 1)->where('type', 'primary_post')->with('user')->limit(2)->get();
            $posts = $category->posts()->latest()->where('is_published', 1)->where('type', 'post')->with('user')->paginate(20);
            return Inertia::render('Category',
                compact('category', 'posts', 'primaryPosts', 'categories')
            );
        }
        else {
            return Inertia::render('Error.404', 404);
        }
    }

    public function post($slug)
    {
        $categories = Category::query()->get();
        $post = Post::query()->where('slug', $slug)->with('category')->with('user')->first();

        if ($post) {
            return Inertia::render('Post',
                compact('post', 'categories')
            );
        }
        else {
            return Inertia::render('Error.404', 404);
        }
    }
}
