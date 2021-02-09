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

        CommentReply::query()->create([
            'user_id' => auth()->id(),
            'post_id' => $request->post_id,
            'comment_id' => $request->comment_id,
            'text' => $request->text,
        ]);
//        return $replay = Replay::query()
//            ->create(['comment_id' => Auth::user()->id, 'post_id' => $request->post_id, 'text' => $request->text])->fresh();
    }
}
