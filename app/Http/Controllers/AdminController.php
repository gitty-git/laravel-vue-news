<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Role;
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
        $users = User::query()->latest()
            ->with('roles')
            ->withCount('posts')->withCount('comments')
            ->paginate(10, ['*'], 'users');

        $comments = $this->moreComments();

        if ($request->wantsJson()) {
            if ($request->loadMoreType === 'morePosts') {
                return $posts;
            }
            else if ($request->loadMoreType === 'moreComments') {
                return $comments;
            }
            else if ($request->loadMoreType === 'moreUsers') {
                return $users;
            }
        }

        return Inertia::render('Admin/Index', compact('posts', 'users', 'comments'));
    }

    public function moreComments() {
        return Comment::query()
            ->latest()
            ->orderByDesc('id')
            ->with('post.user')
            ->withCount('likes')
            ->withCount('comment_replies')
            ->paginate(6, ['*'], 'comments');
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

    public function setAdmin($id)
    {
        $user = User::query()->where('id', $id)->firstOrFail();
        $adminRole = Role::query()->where('role', 'admin')->firstOrFail();
        $user->roles()->attach($adminRole->id);

        return back();
    }

    public function unsetAdmin($id)
    {
        $user = User::query()->where('id', $id)->firstOrFail();
        $adminRole = Role::query()->where('role', 'admin')->firstOrFail();
        $user->roles()->detach($adminRole->id);

        return back();
    }

    public function setRedactor($id)
    {
        $user = User::query()->where('id', $id)->firstOrFail();
        $redactorRole = Role::query()->where('role', 'redactor')->firstOrFail();
        $user->roles()->attach($redactorRole->id);

        return back();
    }

    public function unsetRedactor($id)
    {
        $user = User::query()->where('id', $id)->firstOrFail();
        $redactorRole = Role::query()->where('role', 'redactor')->firstOrFail();
        $user->roles()->detach($redactorRole->id);

        return back();
    }
}
