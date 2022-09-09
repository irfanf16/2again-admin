<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckProfile
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->name == null) {
            return redirect(route('updateProfile'))->with('error', 'Please update your profile to continue');
        }
        if (Auth::user()->profile_pic == null) {
            return redirect(route('updateProfile'))->with('error', 'Please update your profile Picture');
        }
        return $next($request);

    }
}
