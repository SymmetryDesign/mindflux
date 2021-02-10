<?php

namespace App\Http\Middleware;

use Closure;

class AllowIfTenantUser
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->guest()) {
            return redirect()->route('login');
        }

        if (auth()->user()->isTenantOwner() || auth()->user()->isTenantUser()) {
            return $next($request);
        }

        return redirect()->back();
    }
}
