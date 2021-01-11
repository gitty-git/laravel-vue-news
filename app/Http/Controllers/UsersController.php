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


    public function show($id, Request $request): \Inertia\Response
    {
        $user = User::query()->where('id', $id)->first();

//        $posts = Post::query()->offset(2)
//            ->take(12);

        $posts = $user->posts()->latest()->limit(6)->get();

        $postsCounted = $user->posts()->count();

        $comments = $user->comments()->latest()->with('post.user')->limit(5)->get();

        $commentsCounted = $user->comments()->count();

//        dd($comments);

        return Inertia::render('User', compact('posts', 'comments', 'user', 'postsCounted', 'commentsCounted'));

//        return Inertia::render('User', compact('posts', 'user', 'comments'));
//        dd($request);

//        $created_at = $request->sort ?: 'created_at';
//        echo $request->sort;

//        $user = User::query()->where('id', $id)->first();
//        $posts = $user->posts()->withCount('comments')->orderByDesc('created_at')->limit(6)->get();
////        $posts = $user->posts()->latest()->where('is_published', 1)->limit(6)->get();
//        $comments = $user->comments()->latest()->with('post')->paginate(10);
//
//        if ($user) {
//            return Inertia::render('User',
//                compact('posts', 'comments')
//            );
//        }
//        else {
//            return Inertia::render('Error.404', 404);
//        }
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
