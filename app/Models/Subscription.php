<?php

namespace App\Models;

use Billing;
use Carbon\Carbon;

class Subscription extends Model
{
    /**
     * Indicates an active subscription.
     *
     * @var int
     */
    const STATUS_ACTIVE = 1;

    /**
     * Indicates a past due payment subscription.
     *
     * @var int
     */
    const STATUS_PAST_DUE = 2;

    /**
     * Indicates a canceled.
     *
     * @var int
     */
    const STATUS_CANCELED = 3;

    /**
     * Indicates incomplete subscription.
     *
     * @var int
     */
    const STATUS_INCOMPLETE = 4;

    /**
     * The attributes that are mutable to dates.
     *
     * @var array
     */
    protected $dates = [
        'ends_at',
        'trial_ends_at',
    ];

    /**
     * The subscription belongs to a tenant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * The subscription belongs to a plan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Filter active subscription.
     *
     * @param $query
     */
    public function scopeActive($query)
    {
        $query->where(function ($query) {
            $query->whereNull('ends_at')
                ->orWhere(function ($query) {
                    $query->onGracePeriod();
                });
        })->where('status', '!=', Subscription::STATUS_PAST_DUE)
            ->where('status', '!=', Subscription::STATUS_CANCELED)
            ->where('status', '!=', Subscription::STATUS_INCOMPLETE);
    }

    /**
     * Filter canceled subscriptions.
     *
     * @param $query
     */
    public function scopeCanceled($query)
    {
        $query->where('status', Subscription::STATUS_CANCELED);
    }

    /**
     * Filter incomplete subscriptions.
     *
     * @param $query
     */
    public function scopeIncomplete($query)
    {
        $query->where('status', Subscription::STATUS_INCOMPLETE);
    }

    /**
     * Filter query by on grace period.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return void
     */
    public function scopeOnGracePeriod($query)
    {
        $query->whereNotNull('ends_at')->where('ends_at', '>', now());
    }

    /**
     * Determine if the subscription is active.
     *
     * @return bool
     */
    public function isActive()
    {
        return (is_null($this->ends_at) || $this->onGracePeriod()) &&
            $this->status !== Subscription::STATUS_PAST_DUE &&
            $this->status !== Subscription::STATUS_CANCELED &&
            $this->status !== Subscription::STATUS_INCOMPLETE;
    }

    /**
     * Determine if the subscription is active, on trial, or within its grace period.
     *
     * @return bool
     */
    public function valid()
    {
        return $this->isActive() || $this->onTrial() || $this->onGracePeriod();
    }

    /**
     * Determine if the subscription is within its grace period after cancellation.
     *
     * @return bool
     */
    public function onGracePeriod()
    {
        return $this->ends_at && $this->ends_at->isFuture();
    }

    /**
     * Determine if the subscription is incomplete.
     *
     * @return bool
     */
    public function isIncomplete()
    {
        return $this->status === Subscription::STATUS_INCOMPLETE;
    }

    /**
     * Determine if the subscription is within its trial period.
     *
     * @return bool
     */
    public function onTrial()
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    /**
     * Cancel the subscription.
     *
     * @return void
     */
    public function cancel()
    {
        Billing::cancelSubscription($this);
    }

    /**
     * swap customer subscription plan.
     *
     * @param \App\Models\Plan $plan
     * @return \App\Models\Subscription
     */
    public function swap($plan)
    {
        return Billing::swapSubscription($this, $plan);
    }

    /**
     * Retrieve the latest subscription payment
     *
     * @return mixed
     */
    public function latestPayment()
    {
        return Billing::latestSubscriptionPayment($this);
    }

    /**
     * Issue an invoice for the subscription.
     *
     * @return void
     */
    public function invoice()
    {
        Billing::invoiceSubscription($this);
    }

    /**
     * Force the trial to end immediately.
     *
     * This method must be combined with swap, resume, etc.
     *
     * @return $this
     */
    public function skipTrial()
    {
        $this->trial_ends_at = null;

        return $this;
    }

    /**
     * Mark subscription as canceled.
     *
     * @return void
     */
    public function markAsCanceled()
    {
        $this->fill([
            'status'  => Subscription::STATUS_CANCELED,
            'ends_at' => now(),
        ])->save();
    }

    /**
     * Retrieve payment gateway subscription object instance.
     *
     * @return mixed
     */
    public function asGatewaySubscription()
    {
        if (config('billing.gateway') === 'stripe') {
            /** @var \Stripe\Subscription $subscription */
            $subscription = Billing::retrieveSubscription($this, ['latest_invoice']);

            return (object)[
                'id'                 => $subscription->id,
                'next_billing_cycle' => optional(Carbon::parse($subscription->billing_cycle_anchor))->format('Y-m-d'),
                'plan'               => $subscription->plan->nickname,
                'latest_payment'     => $subscription->latest_invoice->amount_paid,
                'status'             => $this->status,
                'customer_name'      => $this->tenant->name,
                'link'               => $this->link(),
            ];
        }
    }

    /**
     * Generate subscription external link.
     *
     * @return string
     */
    protected function link()
    {
        if (config('billing.gateway') === 'stripe') {
            return sprintf(
                'https://dashboard.stripe.com/subscriptions/%s', $this->external_id
            );
        }
    }
}
