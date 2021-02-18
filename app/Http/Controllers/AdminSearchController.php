<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AdminSearchController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('search');

        $postsCounted = Post::query()
            ->where('title', 'LIKE', "%{$search}%")
//            ->orWhere('body', 'LIKE', "%{$search}%")
            ->count();

        $commentsCounted = Comment::query()
            ->where('text', 'LIKE', "%{$search}%")
//            ->orWhere('body', 'LIKE', "%{$search}%")
            ->count();

        $usersCounted = User::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->count();

//        $users = User::query()
//            ->latest()
//            ->where('name', 'LIKE', "%{$search}%")
//            ->orWhere('email', 'LIKE', "%{$search}%")
//            ->paginate(6, ['*'], 'posts')->appends(['search' => $search]);

        $users = User::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->withCount('posts')
            ->withCount('comments')
            ->with('roles')
            ->paginate(10, ['*'], 'users')->appends(['search' => $search]);

        $posts = Post::query()
            ->latest()
            ->where('title', 'LIKE', "%{$search}%")
//            ->orWhere('body', 'LIKE', "%{$search}%")
            ->paginate(6, ['*'], 'posts')->appends(['search' => $search]);

        $comments = Comment::query()
            ->latest()->with('post.user')
            ->where('text', 'like', "%{$search}%")
            ->paginate(6, ['*'], 'comments')->appends(['search' => $search]);

        if ($request->wantsJson()) {
            if ($request->loadMoreType === 'morePosts') {
                return $posts;
            }
            else if ($request->loadMoreType === 'moreComments') {
                return $comments;
            }
        }

        return Inertia::render('Admin/Searching',
            compact('posts', 'postsCounted', 'search', 'comments', 'commentsCounted', 'users', 'usersCounted')
        );
    }
}
