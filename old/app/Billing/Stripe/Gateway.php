<?php

namespace App\Billing\Stripe;

use App\Exceptions\IncompletePayment;
use App\Exceptions\InvalidCustomer;
use App\Exceptions\SubscriptionUpdateFailure;
use Illuminate\Support\Carbon;
use Stripe\Customer;
use Stripe\Invoice;
use Stripe\PaymentMethod;
use Stripe\SetupIntent;
use Stripe\Stripe;
use Stripe\Subscription as StripeSubscription;

class Gateway
{
    /**
     * Create a new Stripe gateway instance.
     *
     * @param array $config
     * @return void
     */
    public function __construct($config)
    {
        Stripe::setApiKey(
            $config['secret']
        );
    }

    /**
     * Create Stripe setup payment intent.
     *
     * @param \App\Models\Tenant $tenant
     * @return string|null
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function generateClientToken($tenant)
    {
        $intent = SetupIntent::create([
            'customer' => $tenant->customer_id,
        ]);

        return $intent->client_secret;
    }

    /**
     * Create a new Stripe customer.
     *
     * @param \App\Models\Tenant $tenant
     * @return \App\Models\Tenant
     * @throws \App\Exceptions\InvalidCustomer
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function createCustomer($tenant)
    {
        $this->assertCustomerNotExists($tenant);

        $customer = Customer::create([
            'name'  => $tenant->name,
            'email' => $tenant->owner()->email,
        ]);

        $tenant->fill(['customer_id' => $customer->id])->save();

        return $tenant;
    }

    /**
     * Update an existing Stripe customer.
     *
     * @param \App\Models\Tenant $tenant
     * @return \App\Models\Tenant
     * @throws \App\Exceptions\InvalidCustomer
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function updateCustomer($tenant)
    {
        $customer = $this->resolveStripeCustomer($tenant);

        $customer->updateAttributes([
            'name'    => $tenant->name,
            'phone'   => $tenant->phone,
            'address' => [
                'line1'       => $tenant->address_line1,
                'line2'       => $tenant->address_line2,
                'country'     => $tenant->country,
                'city'        => $tenant->city,
                'postal_code' => $tenant->postal_code,
                'state'       => $tenant->state,
            ]
        ]);

        $customer->save();

        return $tenant;
    }

    /**
     * Get customer payment methods.
     *
     * @param \App\Models\Tenant $tenant
     * @return \Illuminate\Support\Collection
     * @throws \App\Exceptions\InvalidCustomer
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function getPaymentMethods($tenant)
    {
        $customer = $this->resolveStripeCustomer($tenant);

        $paymentMethods = PaymentMethod::all([
            'customer' => $tenant->customer_id,
            'type'     => 'card',
        ]);

        return collect($paymentMethods->data)->map(function ($paymentMethod) use ($customer) {
            return (object)[
                'token'    => $paymentMethod->id,
                'brand'    => $paymentMethod->card->brand,
                'expMonth' => $paymentMethod->card->exp_month,
                'expYear'  => $paymentMethod->card->exp_year,
                'last4'    => $paymentMethod->card->last4,
                'default'  => $paymentMethod->id === $customer->invoice_settings->default_payment_method,
                'type'     => 'card',
            ];
        });
    }

    /**
     * Add payment method to the customer.
     *
     * @param \App\Models\Tenant $tenant
     * @param string $paymentMethod
     * @return \Stripe\PaymentMethod PaymentMethod
     * @throws \App\Exceptions\InvalidCustomer
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function addPaymentMethod($tenant, $paymentMethod)
    {
        $this->assertCustomerExists($tenant);

        $stripePaymentMethod = $this->resolveStripePaymentMethod($paymentMethod);

        if ($stripePaymentMethod->customer !== $tenant->customer_id) {
            $stripePaymentMethod = $stripePaymentMethod->attach([
                'customer' => $this->stripe_id
            ]);
        }

        $this->setDefaultPaymentMethod($tenant, $stripePaymentMethod);

        return $stripePaymentMethod;
    }

    /**
     * Set customer's default payment method.
     *
     * @param \App\Models\Tenant $tenant
     * @param \Stripe\PaymentMethod $paymentMethod
     * @return \Stripe\PaymentMethod
     * @throws \App\Exceptions\InvalidCustomer
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function setDefaultPaymentMethod($tenant, $paymentMethod)
    {
        $this->assertCustomerExists($tenant);

        $customer = Customer::retrieve($tenant->customer_id);

        $stripePaymentMethod = $this->resolveStripePaymentMethod($paymentMethod);

        $customer->invoice_settings = ['default_payment_method' => $stripePaymentMethod->id];

        $customer->save();

        return $paymentMethod;
    }

    /**
     * Remove a payment method from the customer.
     *
     * @param \App\Models\Tenant $tenant
     * @param \Stripe\PaymentMethod|string $paymentMethod
     * @throws \App\Exceptions\InvalidCustomer
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function deletePaymentMethod($tenant, $paymentMethod)
    {
        $this->assertCustomerExists($tenant);

        $stripePaymentMethod = $this->resolveStripePaymentMethod($paymentMethod);

        if ($stripePaymentMethod->customer !== $tenant->customer_id) {
            return;
        }

        $customer = $this->resolveStripeCustomer($tenant);

        $customer->invoice_settings->default_payment_method;

        $stripePaymentMethod->detach(null);
    }

    /**
     * Create a new subscription for the customer.
     *
     * @param \App\Models\Tenant $tenant
     * @param \App\Models\Plan $plan
     * @return \App\Models\Subscription
     * @throws \App\Exceptions\InvalidCustomer
     * @throws \App\Exceptions\PaymentActionRequired
     * @throws \App\Exceptions\PaymentFailure
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function createSubscription($tenant, $plan)
    {
        $this->assertCustomerExists($tenant);

        $customer = $this->resolveStripeCustomer($tenant);

        /** @var \Stripe\Subscription $stripeSubscription */
        $stripeSubscription = $customer->subscriptions->create([
            'billing_cycle_anchor' => null,
            'plan'                 => $plan->external_id,
            'trial_end'            => $plan->trial_days ? now()->addDays($plan->trial_days)->timestamp : null,
            'expand'               => ['latest_invoice.payment_intent'],
            'off_session'          => true,
            'payment_behavior'     => 'allow_incomplete',
        ]);

        /** @var \App\Models\Subscription $subscription */
        $subscription = $tenant->subscriptions()->create([
            'external_id'   => $stripeSubscription->id,
            'plan_id'       => $plan->id,
            'status'        => StripeSubscriptionStatus::determine($stripeSubscription->status),
            'trial_ends_at' => $stripeSubscription->trial_end ? Carbon::parse($stripeSubscription->trial_end) : null,
            'ends_at'       => null,
        ]);

        if ($subscription->isIncomplete()) {
            (new Payment(
                $stripeSubscription->latest_invoice->payment_intent
            ))->validate();
        }

        return $subscription;
    }

    /**
     * Cancel the subscription.
     *
     * @param \App\Models\Subscription $subscription
     * @return \App\Models\Subscription
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function cancelSubscription($subscription)
    {
        $stripeSubscription = $this->resolveStripeSubscription($subscription);

        $stripeSubscription->cancel_at_period_end = true;
        $stripeSubscription = $stripeSubscription->save();

        $subscription->status = StripeSubscriptionStatus::determine($stripeSubscription->status);

        if ($subscription->onTrial()) {
            $subscription->ends_at = $subscription->trial_ends_at;
        } else {
            $subscription->ends_at = Carbon::createFromTimestamp(
                $stripeSubscription->current_period_end
            );
        }

        $subscription->save();

        return $subscription;
    }

    /**
     * Swap customer subscription plan.
     *
     * @param \App\Models\Subscription $subscription
     * @param \App\Models\Plan $plan
     * @return \App\Models\Subscription
     * @throws \App\Exceptions\IncompletePayment
     * @throws \App\Exceptions\InvalidCustomer
     * @throws \App\Exceptions\SubscriptionUpdateFailure
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function swapSubscription($subscription, $plan)
    {
        if ($subscription->isIncomplete()) {
            throw SubscriptionUpdateFailure::incompleteSubscription($subscription);
        }

        $stripeSubscription = $this->resolveStripeSubscription($subscription);

        $stripeSubscription->plan = $plan->external_id;
        $stripeSubscription->proration_behavior = 'create_prorations';
        $stripeSubscription->cancel_at_period_end = false;
        $stripeSubscription->payment_behavior = 'allow_incomplete';

        if ($subscription->onTrial()) {
            $stripeSubscription->trial_end = $subscription->trial_ends_at->getTimestamp();
        } else {
            $stripeSubscription->trial_end = 'now';
        }

        $stripeSubscription->save();

        $subscription->fill([
            'plan_id' => $plan->id,
            'ends_at' => null,
        ])->save();

        if (!$subscription->onTrial()) {
            $this->invoiceSubscription($subscription);
        }

        return $subscription;
    }

    /**
     * Retrieve the latest payment of the given subscription.
     *
     * @param \App\Models\Subscription $subscription
     * @return object
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function latestSubscriptionPayment($subscription)
    {
        $stripeSubscription = $this->resolveStripeSubscription($subscription, ['latest_invoice.payment_intent']);

        return (object)[
            'client_secret' => optional($stripeSubscription->latest_invoice->payment_intent)->client_secret,
            'amount'        => optional($stripeSubscription->latest_invoice->payment_intent)->amount / 100
        ];
    }

    /**
     * Issue an invoice for the given customer subscription.
     *
     * @param \App\Models\Subscription $subscription
     * @return \App\Models\Subscription|bool
     * @throws \App\Exceptions\InvalidCustomer
     * @throws \App\Exceptions\IncompletePayment
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function invoiceSubscription($subscription)
    {
        $this->assertCustomerExists($subscription->tenant);

        try {
            $stripeInvoice = Invoice::create([
                'customer'     => $subscription->tenant->customer_id,
                'subscription' => $subscription->external_id,
            ]);

            $stripeInvoice = $stripeInvoice->pay();

            return $stripeInvoice;
        } catch (IncompletePayment $exception) {
            $subscription->fill([
                'stripe_status' => $exception->payment->invoice->subscription->status,
            ])->save();

            throw $exception;
        }
    }

    /**
     * Retrieve Stripe subscription.
     *
     * @param \App\Models\Subscription $subscription
     * @param array $expand
     * @return \Stripe\StripeSubscription
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function retrieveSubscription($subscription, $expand = [])
    {
        return $this->resolveStripeSubscription($subscription, $expand);
    }

    /**
     * Get the Stripe customer for the model.
     *
     * @param \App\Models\Tenant $tenant
     * @return \Stripe\Customer
     * @throws \App\Exceptions\InvalidCustomer
     * @throws \Stripe\Exception\ApiErrorException
     */
    protected function resolveStripeCustomer($tenant)
    {
        $this->assertCustomerExists($tenant);

        return Customer::retrieve($tenant->customer_id);
    }

    /**
     * Determine if the entity has a Stripe customer ID and throw an exception if not.
     *
     * @param \App\Models\Tenant $tenant
     * @throws \App\Exceptions\InvalidCustomer
     */
    protected function assertCustomerExists($tenant)
    {
        if (!$tenant->customer_id) {
            throw InvalidCustomer::nonCustomer($tenant);
        }
    }

    /**
     * Determine if the entity doesn't have a Stripe customer ID and throw an exception if it does.
     *
     * @param \App\Models\Tenant $tenant
     * @throws \App\Exceptions\InvalidCustomer
     */
    protected function assertCustomerNotExists($tenant)
    {
        if ($tenant->customer_id) {
            throw InvalidCustomer::exists($tenant);
        }
    }

    /**
     * Resolve a PaymentMethod ID to a Stripe PaymentMethod object.
     *
     * @param \Stripe\PaymentMethod|string $paymentMethod
     * @return \Stripe\PaymentMethod
     * @throws \Stripe\Exception\ApiErrorException
     */
    protected function resolveStripePaymentMethod($paymentMethod)
    {
        if ($paymentMethod instanceof PaymentMethod) {
            return $paymentMethod;
        }

        return PaymentMethod::retrieve($paymentMethod);
    }

    /**
     * Resolve subscription model to a Stripe subscription object.
     *
     * @param \App\Models\Subscription $subscription
     * @param array $expand
     * @return \Stripe\Subscription
     * @throws \Stripe\Exception\ApiErrorException
     */
    protected function resolveStripeSubscription($subscription, $expand = [])
    {
        return StripeSubscription::retrieve([
            'id' => $subscription->external_id, 'expand' => $expand
        ]);
    }
}
