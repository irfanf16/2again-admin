<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class rolePermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $permission = null)
    {
          $role='User';
        if($role !==null && $request->user()->hasRole($role)) {
//            abort(404);
            return redirect(route('admin.403'));
        }
        if($permission !== null && !$request->user()->can($permission)) {
//            abort(403);
            return redirect(route('admin.403'));

        }
        return $next($request);
    }
}
