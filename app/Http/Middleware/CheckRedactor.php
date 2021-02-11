<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRedactor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $userRoles = Auth::user()->roles->pluck('role');

        if ($userRoles->contains('redactor') || $userRoles->contains('admin')) {
            return $next($request);
        }
        else {
//            return abort(403);
            return redirect('user/profile');
        }
    }
}
