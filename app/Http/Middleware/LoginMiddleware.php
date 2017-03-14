<?php

namespace App\Http\Middleware;

use Closure;

class LoginMiddleware
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
        if(\Session::has('user_login_session_key')) {
            return $next($request);
        } else {
            \Session::set('return_referer', $request->getRequestUri());
            return  redirect(url('/login'));
        }
    }
}
