<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Log;
use Closure;

class LogAfterRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    public function terminate(\Illuminate\Http\Request $request, $response)
    {
        $url=$request->fullUrl();

        if($request->path() !== "logs"){
            $ip=$request->ip();
            $r = new \App\Request;
            $r->ip=$ip;
            $r->url=substr($url,0,50);
            $r->request=json_encode($request->all());
            $r->response=$response;
            $r->save();
        }
     
    }
}