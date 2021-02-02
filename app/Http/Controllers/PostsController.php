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
use Illuminate\Support\Str;
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

    public function store()
    {
        $post = Post::query()->create($this->validateRequest());

        $this->storeImage($post);
    }

    public function edit(Post $post)
    {
        $categories = Category::query()->get(['id', 'name']);
        return Inertia::render('Posts/Edit', compact('categories', 'post'));
    }

    public function update(Request $request, Post $post)
    {
        $post = Post::where('id', $request->id)->update($this->validateRequest());
        $this->updateImage($post);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        response($post);
    }

    protected function validateRequest(): array
    {
        if (!request()->slug) {
            request()['slug'] = Str::slug(request()->title, '-');
        }

        request()['user_id'] = Auth::user()->id;

        $messages = [
            'title.unique' => 'The title ":input" has already been taken.',
            'slug.unique' => 'The slug ":input" has already been taken.',
            'category_id.required' => 'The category field is required.'
        ];

        return request()->validate([
            'category_id' => 'required',
            'title' => 'required|max:100|unique:posts,title,' . request()->id,
            'brief' => 'required|max:200',
            'image' => ['required' . request()->id, 'image','max:5000', new ImageRatio],
            'image_description' => 'required|max:100',
            'slug' => ['max:100', new SlugRule, 'unique:posts,slug,' . request()->id],
            'is_published' => 'required',
            'type' => 'required',
            'user_id' => 'required'
        ], $messages);
    }

    private function storeImage($post)
    {
        if (request()->has('image')) {
            $post->update([
                'image' => request()->image->store('posts', 'public')
            ]);
        };
    }

    private function updateImage($post)
    {
        if (request()->has('image')) {
            $post->update([
                'image' => request()->image->update('posts', 'public')
            ]);
        };
    }
}
