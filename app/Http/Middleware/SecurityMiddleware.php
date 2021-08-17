<?php

namespace App\Http\Middleware;

use Closure;

class SecurityMiddleware
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
        $authenticator = app(Google2FAAuthenticator::class)->boot($request);
        if ($authenticator->isAuthenticated()) 
        {
            return $next($request);
        }
        return $authenticator->makeRequestOneTimePasswordResponse();
    }
}
