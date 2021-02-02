<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PostLikeController extends Controller
{
    public function store($id)
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
}
