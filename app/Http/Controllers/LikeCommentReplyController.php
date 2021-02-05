<?php

namespace App\Http\Controllers;

use App\Models\CommentReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeCommentReplyController extends Controller
{
    public function store ($id)
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
