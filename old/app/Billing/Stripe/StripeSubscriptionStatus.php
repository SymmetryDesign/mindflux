<?php

namespace App\Billing\Stripe;

use App\Models\Subscription;

class StripeSubscriptionStatus
{
    /**
     * Determine the subscription status code by Stripe status value.
     *
     * @param string $status
     * @return int
     */
    public static function determine($status)
    {
        if ($status === 'active' || $status === 'trialing') {
            return Subscription::STATUS_ACTIVE;
        }

        if ($status === 'past_due') {
            return Subscription::STATUS_PAST_DUE;
        }

        if ($status === 'incomplete') {
            return Subscription::STATUS_INCOMPLETE;
        }

        if ($status === 'canceled') {
            return Subscription::STATUS_CANCELED;
        }
    }
}
