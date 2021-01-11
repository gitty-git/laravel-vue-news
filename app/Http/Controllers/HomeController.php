<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
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

        return Inertia::render('Home',
            compact('categories', 'frontPagePosts', 'posts', 'primaryPosts')
        );
    }
}
