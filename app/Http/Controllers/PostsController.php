<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\CommentReply;
use App\Models\Post;
use App\Models\User;
use App\Rules\ImageRatio;
use App\Rules\SlugRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class PostsController extends Controller
{
    public function index(Request $request)
    {
        $postsCounted = Auth::user()->posts()->count();

        $posts = Auth::user()->posts()->latest()->paginate(10, ['*'], 'posts');

        if ($request->wantsJson()) {
            if ($request->loadMoreType === 'morePosts') {
                return $posts;
            }
        }

        return Inertia::render('Posts/Index', compact('posts', 'postsCounted'));
    }

    public function create(): \Inertia\Response
    {
        $categories = Category::query()->get(['id', 'name']);
        return Inertia::render('Posts/Create', compact('categories'));
    }

    public function store(Request $request)
    {
        $post = Post::query()->create($this->validateRequest($request));
        $this->storeImage($post);
        return redirect('posts')->with('Posted');
    }

    public function edit(Post $post)
    {
        if (Auth::user()->isNot($post->user)) {
            abort(403);
        }
        $categories = Category::query()->get(['id', 'name']);
        return Inertia::render('Posts/Edit', compact('categories', 'post'));
    }

    public function update(Request $request, Post $post)
    {
        if (Auth::user()->isNot($post->user)) {
            abort(403);
        }
        $post->update($this->validateRequest($request, $post->image));
        $this->storeImage($post);
        return redirect('posts')->with('Updated');
    }

    public function destroy(Post $post)
    {
        if (Auth::user()->isNot($post->user)) {
            abort(403);
        }
        $post->delete();
        return redirect('/posts');
    }

    protected function validateRequest($request, $post = null): array
    {
        if (!$request->slug) {
            $request['slug'] = Str::slug($request->title, '-');
        }

        $request['user_id'] = Auth::user()->id;

        $messages = [
            'title.unique' => 'The title ":input" has already been taken.',
            'slug.unique' => 'The slug ":input" has already been taken.',
            'category_id.required' => 'The category field is required.'
        ];

        $required = $post === null ? 'required' : '';

        return $request->validate([
            'category_id' => 'required',
            'title' => 'required|max:100|unique:posts,title,' . $request->id,
            'brief' => 'required|max:200',
            'image' => [$required, new ImageRatio, 'image', 'max:5000'],
            'image_description' => 'required|max:100',
            'slug' => ['max:100', 'unique:posts,slug,' . $request->id],
            'is_published' => 'required',
            'type' => 'required',
            'user_id' => 'required'
        ], $messages);
    }

    private function storeImage($post)
    {
        if (request()->has('image')) {
            $oldFilePath = 'public/' . $post->image;
            $post->update([
                'image' => request()->image->store('posts', 'public')
            ]);
            Storage::delete($oldFilePath);
        };
    }
}
