<?php

namespace PragmaRX\Google2FALaravel;

use Closure;
use PragmaRX\Google2FALaravel\Support\Authenticator;

class Middleware
{
    public function handle($request, Closure $next)
    {
        $authenticator = app(Authenticator::class)->boot($request);

        if(!\Auth::check())
        {
            return $next($request);
        }

        if(session('force_2fa') && me()->user_2fa == 1)
        {
            return $authenticator->makeRequestOneTimePasswordResponse();
        }

        if ($authenticator->isAuthenticated() || me()->user_2fa == 0 || session('google2fa_passed') || me()->panel_lastip == \Request::ip()) {
            return $next($request);
        }

        return $authenticator->makeRequestOneTimePasswordResponse();
    }
}
