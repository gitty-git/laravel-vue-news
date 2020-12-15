<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\PrimaryPost;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::query()->pluck('name', 'id');

        $primaryPosts = PrimaryPost::query()->limit(4)->get();

        $cats = ['politics', 'world', 'business', 'health', 'arts',  'entertainment', 'games'];
        foreach ($cats as $cat) {
            $categoriesPosts[$cat] = Post::query()->whereHas('category', function ($query) use ($cat) {
                $query->where('name', ucfirst($cat));
            })->latest()->limit(5)->with('category')->get();
        }

        return Inertia::render('Home',
            compact('categories','primaryPosts', 'categoriesPosts')
        );
    }
}
