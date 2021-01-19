<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('search');

        $usersCounted = User::query()->where('name', 'LIKE', "%{$search}%")->count();

        $postsCounted = Post::query()
            ->where('title', 'LIKE', "%{$search}%")
            ->orWhere('body', 'LIKE', "%{$search}%")
            ->count();

        $posts = Post::query()
            ->latest()
            ->where('title', 'LIKE', "%{$search}%")
            ->orWhere('body', 'LIKE', "%{$search}%")
            ->paginate(12);

        $users = User::query()
            ->where('name', 'LIKE', "%{$search}%")->get();

        return Inertia::render('SearchPosts',
            compact('posts', 'users', 'postsCounted', 'usersCounted')
        );
    }
}
