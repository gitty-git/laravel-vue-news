<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{

    public function index(Request $request)
    {
        return Auth::user();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id, Request $request): \Inertia\Response
    {
        $user = User::query()->where('id', $id)->with('roles')->firstOrFail();

        $commentsCounted = $user->comments()->count();
        $postsCounted = $user->posts()->count();

        $posts = $user->posts()->latest()->paginate(6, ['*'], 'posts');
        $comments = $user->comments()->latest()->with('post.user')->paginate(6, ['*'], 'comments');

        if ($request->wantsJson()) {
            if ($request->loadMoreType === 'morePosts') {
                return $posts;
            }
            else if ($request->loadMoreType === 'moreComments') {
                return $comments;
            }
        }

        return Inertia::render('User', compact('posts', 'comments', 'user', 'postsCounted', 'commentsCounted'));
    }
    public function edit($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
