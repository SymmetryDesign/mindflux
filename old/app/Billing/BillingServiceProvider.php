<?php

namespace App\Billing;

use Illuminate\Support\ServiceProvider;

class BillingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('billing', function ($app) {
            return new BillingManager($app);
        });
    }
}
