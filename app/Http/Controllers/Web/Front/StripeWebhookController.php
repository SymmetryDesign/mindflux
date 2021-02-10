<?php

namespace App\Http\Controllers\Web\Front;

use App\Billing\Stripe\StripeSubscriptionStatus;
use App\Events\StripeWebhookHandled;
use App\Events\StripeWebhookReceived;
use App\Http\Controllers\Controller;
use App\Http\Middleware\VerifyStripeWebhookSignature;
use App\Models\Plan;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class StripeWebhookController extends Controller
{
    /**
     * Create a new controller instance
     *
     * @return void
     */
    public function __construct()
    {
        if (config('billing.drivers.stripe.secret')) {
            $this->middleware(VerifyStripeWebhookSignature::class);
        }
    }

    /**
     * Handle a Stripe webhook call.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleWebhook(Request $request)
    {
        $payload = json_decode($request->getContent(), true);
        $method = 'handle' . Str::studly(str_replace('.', '_', $payload['type']));

        StripeWebhookReceived::dispatch($payload);

        if (method_exists($this, $method)) {
            $response = $this->{$method}($payload);

            StripeWebhookHandled::dispatch($payload);

            return $response;
        }

        return $this->missingMethod();
    }

    /**
     * Handle customer subscription updated.
     *
     * @param array $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleCustomerSubscriptionUpdated(array $payload)
    {
        if ($tenant = $this->getCustomerByStripeId($payload['data']['object']['customer'])) {
            $data = $payload['data']['object'];

            $tenant->subscriptions->filter(function ($subscription) use ($data) {
                return $subscription->external_id === $data['id'];
            })->each(function ($subscription) use ($data) {
                if (isset($data['status']) && $data['status'] === 'incomplete_expired') {
                    $subscription->delete();

                    return;
                }

                if (isset($data['plan']['id'])) {
                    $plan = Plan::where('external_id', $data['plan']['id'])->first();
                    $subscription->plan_id = $plan->id;
                }

                if (isset($data['trial_end'])) {
                    $trialEnd = Carbon::createFromTimestamp($data['trial_end']);

                    if (!$subscription->trial_ends_at || $subscription->trial_ends_at->ne($trialEnd)) {
                        $subscription->trial_ends_at = $trialEnd;
                    }
                }

                if (isset($data['cancel_at_period_end'])) {
                    if ($data['cancel_at_period_end']) {
                        $subscription->ends_at = $subscription->onTrial()
                            ? $subscription->trial_ends_at
                            : Carbon::createFromTimestamp($data['current_period_end']);
                    } else {
                        $subscription->ends_at = null;
                    }
                }

                if (isset($data['status'])) {
                    $subscription->status = StripeSubscriptionStatus::determine($data['status']);
                }

                $subscription->save();
            });
        }

        return $this->successMethod();
    }

    /**
     * Handle a cancelled customer from a Stripe subscription.
     *
     * @param array $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleCustomerSubscriptionDeleted(array $payload)
    {
        if ($tenant = $this->getCustomerByStripeId($payload['data']['object']['customer'])) {
            $tenant->subscriptions->filter(function ($subscription) use ($payload) {
                return $subscription->external_id === $payload['data']['object']['id'];
            })->each(function ($subscription) {
                $subscription->markAsCanceled();
            });
        }

        return $this->successMethod();
    }

    /**
     * Handle deleted customer.
     *
     * @param array $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleCustomerDeleted(array $payload)
    {
        if ($tenant = $this->getCustomerByStripeId($payload['data']['object']['id'])) {
            $tenant->subscriptions->each(function ($subscription) {
                $subscription->skipTrial()->markAsCanceled();
            });
        }

        return $this->successMethod();
    }

    /**
     * Handle missing webhook method.
     *
     * @return mixed
     */
    protected function missingMethod()
    {
        //
    }

    /**
     * Handle successful calls on the controller.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function successMethod()
    {
        return new Response('Webhook Handled', 200);
    }

    /**
     * Get customer by Stripe ID.
     *
     * @param string $stripeId
     * @return \App\Models\Tenant|null
     */
    protected function getCustomerByStripeId($stripeId)
    {
        if ($stripeId === null) {
            return;
        }

        return Tenant::where('customer_id', $stripeId)->first();
    }
}
