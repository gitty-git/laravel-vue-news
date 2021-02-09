<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentReply;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RepliesController extends Controller
{
    public function store(Request $request)
    {
//        dd($request);

        $commentReply = CommentReply::query()->create([
            'user_id' => auth()->id(),
            'post_id' => $request->post_id,
            'comment_id' => $request->comment_id,
            'text' => $request->text,
        ])->fresh();

        return CommentReply::query()
            ->withCount('likes')
            ->with('user')
            ->find($commentReply->id);
    }
}
