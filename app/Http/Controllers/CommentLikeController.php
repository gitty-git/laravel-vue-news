<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentLikeController extends Controller
{
    public function store($id)
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
}
