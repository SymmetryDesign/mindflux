<?php

namespace App\Exceptions;

use Exception;

class SubscriptionUpdateFailure extends Exception
{
    /**
     * Create a new SubscriptionUpdateFailure instance.
     *
     * @param \App\Models\Subscription $subscription
     * @return static
     */
    public static function incompleteSubscription($subscription)
    {
        return new static(
            "The subscription \"{$subscription->external_id}\" cannot be updated because its payment is incomplete."
        );
    }
}
