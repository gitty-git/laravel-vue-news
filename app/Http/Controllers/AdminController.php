<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index()
    {
        $posts = Post::query()->paginate(6);
        $users = User::query()->paginate(10);
        $comments = Comment::query()->paginate(10);
        return Inertia::render('Admin', compact('posts', 'users', 'comments'));
    }
}
