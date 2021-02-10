<?php

namespace App\Billing;

use App\Billing\Stripe\Gateway as StripeGateway;
use Illuminate\Support\Manager;

class BillingManager extends Manager
{
    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return config('billing.gateway');
    }

    /**
     * Create Stripe driver.
     *
     * @return \App\Billing\Stripe\Gateway
     */
    protected function createStripeDriver()
    {
        return new StripeGateway(
            config('billing.drivers.stripe')
        );
    }
}
