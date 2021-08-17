<?php

namespace App\Http\Middleware;

use Closure;

class OwnerAccess
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
        $me = me();

        if($me->user_admin < 6 && $me->id != 1)
        {
            session()->flash('error', 'Unauthorized access!');
            return redirect('/');
        }

        return $next($request);
    }
}
