<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UsersController extends Controller
{
    public function index()
    {
        return Auth::user();
    }

    public function show(User $user)
    {
        return Inertia::render('Users/Show',compact('user'));
    }

    public function destroy(Request $request, User $user)
    {
        $user->delete();
        return back();
    }
}
