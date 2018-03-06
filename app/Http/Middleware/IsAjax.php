<?php

namespace App\Http\Middleware;

use Closure;

class IsAjax
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
        if(!$request->ajax()) {
            //return false if not a ajax request
            return response()->json(['flag' => false, 'message' => "Bad Request!", 'code' => "400"]);
        }
        return $next($request);
    }
}
