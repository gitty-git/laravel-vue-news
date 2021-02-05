<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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


    public function store(Request $request)
    {
//        Comment::query()->where('user_id', Auth::user()->id)->where('post_id')
//        dd($request);
//        $comment = Comment::query()->create($this->validateRequest($request));
//        dd($request->text);
        $comment = Comment::query()
            ->create(['user_id' => Auth::user()->id, 'post_id' => $request->post_id, 'text' => $request->text])->fresh();

        return Comment::query()
            ->with('comment_replies')
            ->with('comment_replies.user')
            ->with('comment_replies.likes')
            ->withCount('likes')
            ->with('user')
            ->find($comment->id);

//        return $responseComment;

//        return $comment::query()
//            ->where('user_id', Auth::user()->id)
//            ->where('post_id', $request->post_id)
//            ->with('comment_replies')
//            ->with('comment_replies.user')
//            ->with('comment_replies.likes')
//            ->withCount('likes')
//            ->with('user')
//            ->firstOrFail();
    }

    public function show($id)
    {
        dd(Comment::query()->where('post_id', $id)->get());
        return Comment::query()->where('post_id', $id)->get();

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Comment $comment)
    {
        if (Auth::user()->isNot($comment->user)) {
            abort(403);
        }

        $comment->delete();
    }

    private function validateRequest($request)
    {
        return $request->validate([
            'text' => 'required|max:255|text'
        ]);
    }
}
