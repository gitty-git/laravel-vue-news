<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentReply;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PostController extends Controller
{
    public function show($slug, Request $request)
    {
        $post = Post::query()->where('slug', $slug)
            ->with('category')
            ->with('user')
            ->with('likes')
            ->withCount('comments')
            ->withCount('likes')
            ->firstOrFail();

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
}
