<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App\RolePermission;
use Illuminate\Support\Facades\Auth;

class CheckValidAdminAuth {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)     {
		if(Session::has('authenticated') && Session::has('authenticated_user')):
            $permissions = RolePermission::join('permissions as p', 'p.id', '=', 'role_permissions.permission')
                            ->where('role_permissions.role', Auth::user()->role)
                            ->pluck('p.permission')
                            ->toArray();
            $request->request->add(['permissions' => $permissions]);
			return $next($request);
		endif;
		
		return redirect('/auth');
    }
}
