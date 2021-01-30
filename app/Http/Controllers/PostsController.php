<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\CommentReply;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PostsController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }


    public function show($slug, Request $request)
    {
        $post = Post::query()->where('slug', $slug)
            ->with('category')
            ->with('user')
            ->with('likes')
            ->withCount('comments')
            ->withCount('likes')
            ->first();

        if (Auth::user()) $postLiked = true ? $post->likes->contains(Auth::user()->id) : false;
        else $postLiked = false;

        $comments = Comment::query()->where('post_id', $post->id)->latest()
            ->with('comment_replies')
            ->with('comment_replies.user')
            ->with('comment_replies.likes')
            ->withCount('likes')
            ->with('user')->paginate(20);

        $commentReplies = CommentReply::query()->where('post_id', $post->id)->latest()
            ->withCount('likes')
            ->with('user')->paginate(20);

        if ($request->wantsJson()) {
            return $comments;
        }

        if ($post) {
            return Inertia::render('Post',
                compact('post', 'comments', 'postLiked', 'commentReplies')
            );
        }
        else {
            return Inertia::render('Error.404', 404);
        }
    }

    public function edit(Post $post)
    {
        //
    }

    public function update(Request $request, Post $post)
    {
        //
    }

    public function destroy(Post $post)
    {
        //
    }

    public function postLike ($id)
    {
        $post = Post::where('id', $id)->first();

        if (!$post->likes->contains(Auth::user()->id)) {
            $postLiked = true;
            $post->likes()->attach(Auth::user()->id);
        }
        else {
            $postLiked = false;
            $post->likes()->detach(Auth::user()->id);
        }

        $postLikesCount = Post::where('id', $id)->first()->likes->count();

        return response(compact('postLikesCount', 'postLiked'));
    }

    public function commentLike ($id)
    {
        $comment = Comment::where('id', $id)->first();

        if (!$comment->likes->contains(Auth::user()->id)) {
            $comment->toggleLike()->save();
            $comment->likes()->attach(Auth::user()->id);
        }
        else {
            $comment->toggleLike()->save();
            $comment->likes()->detach(Auth::user()->id);
        }

        $comment = Comment::where('id', $id)
            ->withCount('likes')->first();

        return response(compact( 'comment'));
    }

    public function commentReplyLike ($id)
    {
        $commentReply = CommentReply::where('id', $id)->first();

        if (!$commentReply->likes->contains(Auth::user()->id)) {
            $commentReply->toggleLike()->save();
            $commentReply->likes()->attach(Auth::user()->id);
        }
        else {
            $commentReply->toggleLike()->save();
            $commentReply->likes()->detach(Auth::user()->id);
        }

        $commentReply = CommentReply::where('id', $id)
            ->with('likes')->first();

        return response(compact( 'commentReply'));
    }
}
