<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $request->user();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    public function show($id, Request $request)
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
