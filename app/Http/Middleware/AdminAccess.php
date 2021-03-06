<?php

namespace App\Http\Middleware;

use Closure;

class AdminAccess
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
        if(me()->user_admin == 0)
        {
            session()->flash('error', 'Unauthorized access!');
            return redirect('/');
        }
        return $next($request);
    }
}
