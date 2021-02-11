<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $userRoles = Auth::user()->roles->pluck('role');

        if ($userRoles->contains('admin')) {
            return $next($request);
        }
        else {
//            return abort(403);
            return $next($request);
            return redirect('user/profile');
        }
    }
}
