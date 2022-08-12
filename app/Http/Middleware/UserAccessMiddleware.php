<?php

namespace App\Http\Middleware;

use Closure;
use App\UserRole;
use App\RolePermission;
use Illuminate\Support\Facades\Auth;

class UserAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        $user = Auth::user();
        $permissions = $request->get('permissions');
        if(in_array($permission, $permissions))
            return $next($request);
        else
            return redirect()->route('admin.home')->with('error', 'You don\'t has permission to access this page');
    }
}
