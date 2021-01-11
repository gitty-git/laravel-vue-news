<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PostsController extends Controller
{
    public function index()
    {

    }

//    public function index()
//    {
//        return Post::offset(request('offset'))
//            ->take(12)
//            ->with(['category'])
//            ->orderBy('created_at', 'DESC')
//            ->get(['id', 'title', 'preview_img', 'category_id']);
//    }

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


    public function show($slug)
    {
        $post = Post::query()->where('slug', $slug)
            ->with('category')
            ->with('user')
            ->withCount('comments')
            ->first();

        $comments = Comment::query()->where('post_id', $post->id)->latest()
            ->with('comment_replies')
            ->with('comment_replies.user')
            ->with('user')->paginate(1);
//        $comments_replies = Comment::query()->where('post_id', $post->id)->get();

        if ($post) {
            return Inertia::render('Post',
                compact('post', 'comments',)
            );
        }
        else {
            return Inertia::render('Error.404', 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
