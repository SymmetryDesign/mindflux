<?php

namespace App\Http\Middleware;

use Closure;

class PreventIfLimitExceeded
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
        if (tenant()->exceededPlanLimits()) {
            return redirect()->back()->withErrors([
                'plan.limit' => 'Plan limits exceeded. Please upgrade your plan to continue this action'
            ]);
        }

        return $next($request);
    }
}
