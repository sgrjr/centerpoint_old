<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
		
         if (!\Schema::hasTable('users')) {
            return redirect('/setup');
        }
		
<<<<<<< HEAD
        //Conditions under which requested path is refused
        if(auth()->check() === false || auth()->user()->can("MODIFY_ADMIN_RESOURCE")){
=======
        $viewer =  new \App\Viewer();

        if ($viewer->can("MODIFY_ADMIN_RESOURCE") === false ){
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }

        return $next($request);
    }
}
