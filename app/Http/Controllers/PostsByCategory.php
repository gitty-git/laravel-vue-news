<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostsByCategory extends Controller
{
    public function show($slug)
    {
        $category = Category::query()->where('slug', $slug)->first();

        if ($category) {
            $primaryPosts = $category->posts()->latest()->where('is_published', 1)->where('type', 'primary_post')
                ->with('user')->with('category')->limit(2)->get();
            $posts = $category->posts()->latest()->where('is_published', 1)->where('type', 'post')->with('user')->paginate(20);

            return Inertia::render('Category',
                compact('category', 'posts', 'primaryPosts')
            );
        }
        else {
            return Inertia::render('Error.404', 404);
        }
    }
}
