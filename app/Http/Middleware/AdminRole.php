<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\Permission\Exceptions\UnauthorizedException;
class AdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guest()) {
            throw UnauthorizedException::notLoggedIn();
        }
        if(auth()->check() ){
            $user = Auth::user();
            $role_user = $user->roles;
            if($role_user->name_role == "Admin"){
                return $next($request);
            }
        }

        return Inertia::render('Error', ['status' =>403]);
    }
}
