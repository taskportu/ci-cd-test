<?php
namespace App\Http\Middleware;
use Closure;

class CheckValidBothAuth {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)     {
    	dd(!empty(session('authenticated')) ,
			!empty(session('user')), session('user'));
		 if(
		 	!empty(session('authenticated')) ||
			!empty(session('user'))
		):
			//$request->session()->put('authenticated', 'admin');
			//$request->session()->put('user', 'user');
			return $next($request);
		endif;
		
		return redirect('/auth');
    }
}