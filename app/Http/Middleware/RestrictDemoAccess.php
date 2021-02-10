<?php

namespace App\Http\Middleware;

use Closure;

class RestrictDemoAccess
{
    /**
     * List of restricted routes on demo environment.
     *
     * @var array
     */
    protected $routes = [
        'admin:profile.update',
        'admin:password.update',
        'admin:plans.store',
        'admin:plans.update',
        'admin:system-setings.update',
        'admin:landing-page-hero-settings.update',
        'admin:landing-page-pricing-settings.update',
        'admin:landing-page-features-settings.update',
        'admin:landing-page-features.store',
        'admin:landing-page-features.update',
        'admin:landing-page-features.destroy',
        'admin:privacy-policy.update',
        'admin:terms-and-conditions.update',
        'admin:homepage-settings.update',
        'app:profile.update',
        'app:password.update',
        'app:users.update',
        'app:subscription.store',
        'app:subscription.destroy',
        'app:payment-methods.store',
        'app:payment-methods.update',
        'app:payment-methods.destroy',
        'app:billing-information.update',
        'app:system-preferences.update',
        'app:email-notifications.update',
    ];

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (app()->environment('demo') && $request->routeIs('login') && $request->query('demo') === 'admin') {
            auth()->loginUsingId(1);

            return redirect()->route('admin:dashboard');
        }

        if (app()->environment('demo') && $request->routeIs('login') && $request->query('demo') === 'tenant') {
            auth()->loginUsingId(2);

            return redirect()->route('app:dashboard');
        }

        if (app()->environment('demo') && in_array($request->route()->getName(), $this->routes)) {
            return redirect()->back()->withErrors([
                'demo.restrict' => 'This feature is disabled on demo mode'
            ]);
        }

        return $next($request);
    }
}
