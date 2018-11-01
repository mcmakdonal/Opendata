<?php

namespace App\Http\Middleware;

use Closure;

class isLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $m_type = "", $m_ogz = "")
    {
        if (!(\Cookie::get('token') !== null)) {
            abort(404);
        }
        if ($m_type !== "") {
            if ((\Cookie::get('m_type') !== $m_type)) {
                abort(404);
            }
        }

        return $next($request);
    }
}
