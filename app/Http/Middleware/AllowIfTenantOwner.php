<?php

namespace App\Http\Middleware;

use Closure;

class AllowIfTenantOwner
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, Closure $next)
    {
        if (auth()->guest()) {
            return redirect()->route('login');
        }

        if (auth()->user()->isTenantOwner()) {
            return $next($request);
        }

        return back();
    }
}
