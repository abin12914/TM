<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role1, $role2)
    {
        $userRole = Auth::user()->role;

        if(!($role1 == $userRole || $role2 == $userRole)) {
            return redirect()->back()->with("message"," Unauthorized action. You don't have permission to access the option you requested.")
                                                ->with("alert-class","alert-danger");
        }
        return $next($request);
    }
}
