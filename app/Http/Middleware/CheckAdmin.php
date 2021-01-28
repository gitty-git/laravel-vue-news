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
            return redirect('admin');
        }
        elseif ($userRoles->contains('user')) {
            return redirect('user/profile');
        }
        return $next($request);
//        redirect('no-permission');
    }
}
