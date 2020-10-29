<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
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
        if (Auth::guard($guard)->guest()) {

            if ($request->ajax() || $request->wantsJson()) {
<<<<<<< HEAD
               return \App\Helpers\Misc::api(['error'=>'401. Not authorized'], 401);
=======
               return response('Unauthorized.', 401);
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
            } else {
                return redirect()->guest('login');
            }
        }

        return $next($request);
    }
}
