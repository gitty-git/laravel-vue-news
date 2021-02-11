<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AdminSearchController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('search');

        $postsCounted = Auth::user()->posts()
            ->where('title', 'LIKE', "%{$search}%")
//            ->orWhere('body', 'LIKE', "%{$search}%")
            ->count();

        $commentsCounted = Auth::user()->comments()
            ->where('text', 'LIKE', "%{$search}%")
//            ->orWhere('body', 'LIKE', "%{$search}%")
            ->count();

        $posts = Auth::user()->posts()
            ->latest()
            ->where('title', 'LIKE', "%{$search}%")
//            ->orWhere('body', 'LIKE', "%{$search}%")
            ->paginate(6, ['*'], 'posts')->appends(['search' => $search]);

        $comments = Auth::user()->comments()
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

        return Inertia::render('AdminSearching',
            compact('posts', 'postsCounted', 'search', 'comments', 'commentsCounted')
        );
    }
}
