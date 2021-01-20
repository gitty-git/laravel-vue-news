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
//            ->orWhere('body', 'LIKE', "%{$search}%")
            ->count();

        $posts = Post::query()
            ->latest()
            ->where('title', 'LIKE', "%{$search}%")
//            ->orWhere('body', 'LIKE', "%{$search}%")
            ->paginate(6, ['*'], 'posts')->appends(['search' => $search]);

        $users = User::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->withCount('posts')
            ->withCount('comments')
            ->with('roles')
            ->paginate(9, ['*'], 'users')->appends(['search' => $search]);

        if ($request->wantsJson()) {
            if ($request->loadMoreType === 'morePosts') {
                return $posts;
            }
            else if ($request->loadMoreType === 'moreUsers') {
                return $users;
            }
        }

        return Inertia::render('SearchingPage',
            compact('posts', 'users', 'postsCounted', 'usersCounted', 'search')
        );
    }
}
