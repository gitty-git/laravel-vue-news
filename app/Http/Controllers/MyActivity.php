<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\In;
use Inertia\Inertia;

class MyActivity extends Controller
{
    public function index(Request $request)
    {
        $commentsCounted = Auth::user()->comments()->count();
        $likedPostsCounted = Auth::user()->post_likes()->count();

        $comments = Auth::user()->comments()->latest()->with('post.user')
            ->withCount('likes')
            ->withCount('comment_replies')->paginate(6, ['*'], 'comments');
        $likedPosts = Auth::user()->post_likes()->latest()->paginate(6, ['*'], 'post_likes');

        if ($request->wantsJson()) {
            if ($request->loadMoreType === 'moreLikedPosts') {
                return $likedPosts;
            }
            else if ($request->loadMoreType === 'moreComments') {
                return $comments;
            }
        }

        return Inertia::render('MyActivity', compact(
            'comments',
            'commentsCounted',
            'likedPosts',
            'likedPostsCounted'
        ));
    }

    public function admin()
    {
        $user = Auth::user();
        $posts = Auth::user()->posts()->get();
        $comments = Auth::user()->comments()->get();
        $users = User::query()->limit(5)->with('roles')->get();

        return Inertia::render('Dashboard/Admin', compact('user', 'posts', 'comments', 'users'));
    }

    public function redactor()
    {

    }

    public function user()
    {
        $user = Auth::user();
        $posts = Post::query()->where('user', Auth::user())->get();
        $comments = Auth::user()->comments()->get();

        $userRoles = Auth::user()->roles->pluck('role');

        if ($userRoles->contains('redactor')) {
            return Inertia::render('Dashboard/User', compact('user', 'posts', 'comments'));
        }
        elseif ($userRoles->Contains(!'redactor' && !'admin')) {
            return Inertia::render('Dashboard/User', compact('user', 'comments'));
        }
    }

    public function editUser($id) {
        $userRoles = Auth::user()->roles->pluck('role');

        if (!$userRoles->contains('admin')) {
            return abort(403, 'Forbidden');
        }

        $user = User::query()->where('id', $id)->with('roles')->firstOrFail();

        $commentsCounted = $user->comments()->count();
        $postsCounted = $user->posts()->count();

        $posts = $user->posts()->latest()->paginate(6, ['*'], 'posts');
        $comments = $user->comments()->latest()->with('post.user')->paginate(6, ['*'], 'comments');

        return Inertia::render(
            'Dashboard/EditUser',
            compact('user', 'commentsCounted', 'postsCounted', 'posts', 'comments')
        );
    }

    public function setAdmin($id)
    {
        $user = User::query()->where('id', $id)->firstOrFail();
        $adminRole = Role::query()->where('role', 'admin')->firstOrFail();
        $user->roles()->attach($adminRole->id);

        return redirect('/admin/edit-user/' . $id);
    }

    public function unsetAdmin($id)
    {
        $user = User::query()->where('id', $id)->firstOrFail();
        $adminRole = Role::query()->where('role', 'admin')->firstOrFail();
        $user->roles()->detach($adminRole->id);

        return redirect('/admin/edit-user/' . $id);
    }

    public function setRedactor($id)
    {
        $user = User::query()->where('id', $id)->firstOrFail();
        $redactorRole = Role::query()->where('role', 'redactor')->firstOrFail();
        $user->roles()->attach($redactorRole->id);

        return redirect('/admin/edit-user/' . $id);
    }

    public function unsetRedactor($id)
    {
        $user = User::query()->where('id', $id)->firstOrFail();
        $redactorRole = Role::query()->where('role', 'redactor')->firstOrFail();
        $user->roles()->detach($redactorRole->id);

        return redirect('/admin/edit-user/' . $id);
    }

    public function destroy($id)
    {
        User::query()->where('id', $id)->delete();
        return redirect('/admin');
    }

}
