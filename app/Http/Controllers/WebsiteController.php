<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class WebsiteController extends Controller
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

    public function post($slug)
    {
        $user = Auth::user();

        $categories = Category::query()->get();

        $post = Post::query()->where('slug', $slug)->with('category')->with('user')->first();

        $comments = Comment::query()->where('post_id', $post->id)->latest()
            ->with('comment_replies')
            ->with('comment_replies.user')
            ->with('user')->paginate(1);
//        $comments_replies = Comment::query()->where('post_id', $post->id)->get();

        if ($post) {
            return Inertia::render('Post',
                compact('post', 'categories', 'comments', 'user')
            );
        }
        else {
            return Inertia::render('Error.404', 404);
        }
    }

    public function user($id)
    {
        $user = User::query()->where('id', $id)->first();
        $categories = Category::query()->get();
        $posts = $user->posts()->latest()->where('is_published', 1)->where('type', 'post')->with('user')->paginate(20);

        if ($user) {
            return Inertia::render('User',
                compact('user', 'categories', 'posts')
            );
        }
        else {
            return Inertia::render('Error.404', 404);
        }
    }
}
