<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::query()->latest()->paginate(6, ['*'], 'posts');
        $users = User::query()->latest()->with('roles')->withCount('posts')->withCount('comments')->paginate(10);

//        $comments = $this->moreComments(6);
        $comments = Comment::with('post.user')
            ->latest()
            ->withCount('likes')
            ->withCount('comment_replies')->paginate(6, ['*'], 'comments');

//        if ($request->wantsJson()) {
//            if ($request->loadMoreType === 'morePosts') {
//                return $posts;
//            }
//            else if ($request->loadMoreType === 'moreComments') {
//                return $this->moreComments($request->itemsCount);
//            }
//            else if ($request->loadMoreType === 'moreUsers') {
//                return $users;
//            }
//        }

        return Inertia::render('Admin/Index', compact('posts', 'users', 'comments'));
    }

    public function moreComments($itemsCount) {
        return Comment::with('post.user')
            ->latest()
            ->withCount('likes')
            ->withCount('comment_replies')->paginate($itemsCount, ['*'], 'comments');
    }

    public function editPost(Post $post)
    {
        if (Auth::user()->roles->pluck('role')->contains('admin')) {
            return Inertia::render('Admin/EditPost', compact('categories', 'post'));
        }
        else abort(403);
    }

    public function destroyPost(Post $post)
    {
        if (Auth::user()->roles->pluck('role')->contains('admin')) {
            abort(403);
        }
        $post->delete();
        return back();
    }
}
